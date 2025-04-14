<?php

namespace App\Http\Domains\Order\Repository;

use App\Http\Domains\Order\Contract\OrderRepositoryInterface;
use App\Http\Domains\Order\DTO\OrderDto;
use App\Http\Domains\Order\Event\StockThresholdExceeded;
use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Model\OrderItem;
use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\Product\Model\MerchantProduct;
use App\Http\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected function model(): string
    {
        return Order::class;
    }

    public function list(?Builder $builder = null): LengthAwarePaginator
    {
        $query = $builder ?? (new Order)->newQuery()->with(['orderItems']);
        return parent::list($query);
    }

    public static function getOrderItems(array $itemIds): EloquentCollection
    {
        return MerchantProduct::with(['merchantProductIngredients.merchantIngredient', 'product'])
            ->whereIn('id', $itemIds)
            ->get();
    }

    /**
     * Submit a new order and update ingredient stock in an atomic transaction.
     *
     * @throws \Exception
     */
    public function submit(OrderDto $orderDto): Order
    {
        return DB::transaction(function () use ($orderDto) {
            $order = $this->createOrder($orderDto);
            $this->attachOrderItems($orderDto, $order);
            $this->updateIngredientStock($order);
            return $order;
        }, 3);
    }

    private function createOrder(OrderDto $orderDto): Order
    {
        $order = Order::create([
                'user_id' => $orderDto->userId,
                'merchant_id' => $orderDto->merchantId,
                'total_amount' => $orderDto->totalAmount,
                'status' => $orderDto->status,
                'notes' => $orderDto->notes,
            ]
        );
        $serialNumber = $order->orderSerialNumber()->create();
        $order->serial_number = $serialNumber->id;
        $order->save();

        return $order;
    }

    private function attachOrderItems(OrderDto $orderDto, Order $order): void
    {
        $orderItems = $orderDto->items->map(function ($item) use ($order) {
            return [
                'order_id' => $order->id,
                'merchant_product_id' => $item->merchantProductId,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total,
            ];
        })->toArray();

        OrderItem::insert($orderItems);
    }

    private function updateIngredientStock(Order $order): void
    {
        $orderItems = OrderItem::with(['merchantProduct.merchantProductIngredients.merchantIngredient'])
            ->where('id', $order->id)
            ->get();
        foreach ($orderItems as $orderItem) {
            $merchantProduct = $orderItem->merchantProduct;
            foreach ($merchantProduct->merchantProductIngredients as $mpi) {
                $merchantIngredient =  $mpi->merchantIngredient;
                $currentStock = $merchantIngredient->stock;
                $requiredQty = $mpi->quantity * $orderItem->quantity;
                logger('requiredQty', [$requiredQty, $mpi->quantity, $orderItem->quantity]);

                $merchantIngredient->decrement('stock', $requiredQty);
                $merchantIngredient->save();
                StockThresholdExceeded::dispatchIf(
                    $this->isThresholdExceeded($currentStock, $merchantIngredient),
                    $merchantIngredient
                );
            }
            logger('outloop', [$orderItem->quantity]);
        }
        //dd(2);
    }

    private function isThresholdExceeded(int $currentStock, MerchantIngredient $merchantIngredient): bool
    {
        $threshold = $merchantIngredient->max_capacity * 0.5;

        return $currentStock >= $threshold && $merchantIngredient->stock < $threshold;
    }
}
