<?php

namespace App\Http\Domains\Order;


use App\Http\Controllers\Controller;
use App\Http\Domains\Order\Request\CreateOrderRequest;
use App\Http\Domains\Order\Resource\OrderResource;
use App\Http\Domains\Order\Service\OrderService;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{
    public function __construct(
        private OrderService $service
    )
    {
    }

    public function store(CreateOrderRequest $request)
    {
        $orderDto = $this->service->prepareOrder($request->validated());
        $order = $this->service->submit($orderDto);
        $order = $this->service->loadRelations($order, ['orderItems', 'merchant', 'user']);

        return $this->responseResource(OrderResource::make($order), status: 201);
    }

    public function list(): JsonResponse
    {
        $orders = $this->service->list();

        return $this->responseResource(
            OrderResource::collection($orders)
        );
    }

}
