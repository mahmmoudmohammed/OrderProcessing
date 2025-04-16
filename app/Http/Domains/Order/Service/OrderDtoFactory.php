<?php

namespace App\Http\Domains\Order\Service;

use App\Http\Domains\Order\DTO\OrderDto;
use App\Http\Domains\Order\DTO\OrderItemDto;
use App\Http\Domains\Order\DTO\OrderRequestDto;
use App\Http\Domains\Order\Model\OrderStatusEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class OrderDtoFactory
{
    /**
     * Create orderDto to be submitted
     */
    public function create(OrderRequestDto $orderRequest, Collection $merchantProducts): OrderDto
    {
        $totalAmount = $this->calculateOrderTotal($orderRequest, $merchantProducts);
        $items = $this->createOrderItems($orderRequest, $merchantProducts);

        return new OrderDto(
            userId: auth()->id(),
            merchantId: $merchantProducts->first()->merchant_id,
            totalAmount: $totalAmount,
            status: OrderStatusEnum::PENDING_PAYMENT,
            notes: $orderRequest->notes,
            items: $items
        );
    }

    private function calculateOrderTotal(OrderRequestDto $orderRequest, Collection $merchantProducts): float
    {
        $total = 0;

        foreach ($merchantProducts as $merchantProduct) {
            $quantity = $orderRequest->merchantProducts[$merchantProduct->id]['quantity'];
            $total += $quantity * $merchantProduct->price;
        }

        return $total;
    }

    private function createOrderItems(OrderRequestDto $orderRequest, Collection $merchantProducts): SupportCollection
    {
        $items = collect();

        foreach ($merchantProducts as $merchantProduct) {
            $quantity = $orderRequest->merchantProducts[$merchantProduct->id]['quantity'];
            $price = $merchantProduct->price;
            $total = $price * $quantity;

            $items->push(new OrderItemDto(
                merchantProduct: $merchantProduct,
                quantity: $quantity,
                price: $price,
                total: $total
            ));
        }

        return $items;
    }
}
