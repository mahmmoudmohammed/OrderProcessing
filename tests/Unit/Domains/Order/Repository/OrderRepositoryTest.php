<?php

namespace Tests\Unit\Domains\Order\Repository;

use App\Http\Domains\Order\DTO\OrderDto;
use App\Http\Domains\Order\DTO\OrderItemDto;
use App\Http\Domains\Order\Event\StockThresholdExceeded;
use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Model\OrderItem;
use App\Http\Domains\Order\Model\OrderStatusEnum;
use App\Http\Domains\Order\Repository\OrderRepository;
use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\Product\Model\MerchantProduct;
use App\Http\Domains\Product\Model\MerchantProductIngredient;
use App\Http\Domains\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private OrderRepository $orderRepository;
    private User $user;
    private MerchantProduct $merchantProduct;
    private MerchantIngredient $merchantIngredient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = new OrderRepository();
        $this->setUpTestData();
    }


    private function createOrderDto(): OrderDto
    {
        $orderItemsCollection = collect([
            new OrderItemDto(
                merchantProductId: $this->merchantProduct->id,
                quantity: 2,
                price: 100.0,
                total: 200.0
            )
        ]);

        return new OrderDto(
            userId: $this->user->id,
            merchantId: $this->merchantProduct->merchant_id,
            totalAmount: 200.0,
            status: OrderStatusEnum::PENDING_PAYMENT,
            notes: 'Test order',
            items: $orderItemsCollection
        );
    }

    private function setUpTestData(): void
    {
        $this->user = User::factory()->create();
        $this->merchantProduct = MerchantProduct::factory()->create([
            'price' => 100.0,
        ]);
        $this->merchantIngredient = MerchantIngredient::factory()->create([
            'merchant_id' => $this->merchantProduct->merchant_id,
            'stock' => 100,
            'max_capacity' => 200,
        ]);
        MerchantProductIngredient::factory()->create([
            'merchant_product_id' => $this->merchantProduct->id,
            'merchant_ingredient_id' => $this->merchantIngredient->id,
            'quantity' => 10,
        ]);

    }

    /** @test */
    public function it_does_not_dispatch_threshold_event_when_stock_stays_above_threshold()
    {
        Event::fake();

        $this->merchantIngredient->max_capacity = 100; // threshold = 50
        // order required ingredient qty = 20 => 80 - 20 = 60 > threshold
        $this->merchantIngredient->stock = 80;
        $this->merchantIngredient->save();
        $orderDto = $this->createOrderDto();
        $this->orderRepository->submit($orderDto);

        Event::assertNotDispatched(StockThresholdExceeded::class);
    }

    /** @test */
    public function it_dispatches_threshold_event_when_stock_drops_below_threshold()
    {
        Event::fake();

        $this->merchantIngredient->max_capacity = 100;
        $this->merchantIngredient->stock = 55;
        $this->merchantIngredient->save();
        $orderDto = $this->createOrderDto();
        $this->orderRepository->submit($orderDto);

        Event::assertDispatched(function (StockThresholdExceeded $event) {
            return $event->merchantIngredient->id === $this->merchantIngredient->id;
        });
    }

    /** @test
     * @testdox Ensure Repository creates unique serial number the order
     */
    public function it_creates_serial_number_for_order()
    {
        $orderDto = $this->createOrderDto();
        $order = $this->orderRepository->submit($orderDto);

        $this->assertNotNull($order->serial_number);
        $this->assertDatabaseHas('order_serial_numbers', [
            'id' => $order->serial_number,
        ]);
    }

    /** @test */
    public function it_creates_an_order_with_items_and_updates_stock()
    {
        $orderDto = $this->createOrderDto();
        $initialStock = $this->merchantIngredient->stock;
        $expectedStockReduction = 20;

        $order = $this->orderRepository->submit($orderDto);

        $this->merchantIngredient->refresh();
        $this->assertInstanceOf(Order::class, $order);
        $this->assertOrderInserted($order, $orderDto);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'merchant_product_id' => $this->merchantProduct->id,
            'quantity' => 2,
            'price' => 100.0,
            'total' => 200.0,
        ]);

        $this->assertEquals(
            $initialStock - $expectedStockReduction,
            $this->merchantIngredient->stock,
        );
    }


    /** @test */
    public function it_correctly_handles_multiple_products_and_ingredients()
    {
        $merchantProduct2 = MerchantProduct::factory()->create([
            'merchant_id' => $this->merchantProduct->merchant_id,
            'price' => 150.0,
        ]);

        $merchantIngredient2 = MerchantIngredient::factory()->create([
            'merchant_id' => $this->merchantProduct->merchant_id,
            'stock' => 100,
            'max_capacity' => 200,
        ]);

        MerchantProductIngredient::factory()->create([
            'merchant_product_id' => $merchantProduct2->id,
            'merchant_ingredient_id' => $merchantIngredient2->id,
            'quantity' => 5,
        ]);
        $orderItemsCollection = collect([
            new OrderItemDto(
                merchantProductId: $this->merchantProduct->id,
                quantity: 2,
                price: 100.0,
                total: 200.0
            ),
            new OrderItemDto(
                merchantProductId: $merchantProduct2->id,
                quantity: 3,
                price: 150.0,
                total: 450.0
            )
        ]);
        $orderDto = new OrderDto(
            userId: $this->user->id,
            merchantId: $this->merchantProduct->merchant_id,
            totalAmount: 650.0,
            status: OrderStatusEnum::PENDING_PAYMENT,
            notes: 'Test order',
            items: $orderItemsCollection
        );
        $initialStock1 = $this->merchantIngredient->stock;
        $initialStock2 = $merchantIngredient2->stock;

        $order = $this->orderRepository->submit($orderDto);

        $this->merchantIngredient->refresh();
        $merchantIngredient2->refresh();

        $this->assertEquals(
            $initialStock1 - 20,
            $this->merchantIngredient->stock,
            'First ingredient stock not updated correctly'
        );

        $this->assertEquals(
            $initialStock2 - 15,
            $merchantIngredient2->stock,
            'Second ingredient stock not updated correctly'
        );
        $this->assertOrderInserted($order, $orderDto);

        $this->assertEquals(2, OrderItem::where('order_id', $order->id)->count());
    }

    private function assertOrderInserted(Order $order, OrderDto $orderDto): void
    {
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $orderDto->userId,
            'merchant_id' => $orderDto->merchantId,
            'total_amount' => $orderDto->totalAmount,
            'status' => $orderDto->status,
        ]);
    }
}
