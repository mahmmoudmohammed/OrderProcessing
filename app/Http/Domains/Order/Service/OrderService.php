<?php

namespace App\Http\Domains\Order\Service;

use App\Http\Domains\Order\DTO\OrderDto;
use App\Http\Domains\Order\DTO\OrderRequestDto;
use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Repository\OrderRepository;

class OrderService
{
    public function __construct(
        private readonly OrderRepository       $orderRepository,
        private readonly OrderValidatorService $orderValidator,
        private readonly OrderDtoFactory       $orderDtoFactory
    )
    {
    }

    public function prepareOrder(array $orderDetails): OrderDto
    {
        $orderRequestDto = new OrderRequestDto($orderDetails);
        $merchantProducts = $this->orderValidator->validateIngredients($orderRequestDto);
        return $this->orderDtoFactory->create($orderRequestDto, $merchantProducts);
    }

    /**
     * @throws \Exception
     */
    public function submit(OrderDto $orderDto): Order
    {
        return $this->orderRepository->submit($orderDto);
    }

    public function loadRelations(Order $order, array $relations)
    {
        return $this->orderRepository->load($order, $relations);
    }

    public function list()
    {
        return $this->orderRepository->list();
    }

}
