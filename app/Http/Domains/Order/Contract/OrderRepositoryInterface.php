<?php

namespace App\Http\Domains\Order\Contract;

use App\Http\Domains\Order\DTO\OrderDto;
use App\Http\Domains\Order\Model\Order;
use App\Http\Repository\BaseOperationsInterface;

interface OrderRepositoryInterface extends BaseOperationsInterface
{
    public function submit(OrderDto $orderDto): Order;

}
