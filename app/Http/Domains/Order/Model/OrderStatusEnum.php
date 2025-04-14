<?php

namespace App\Http\Domains\Order\Model;

enum OrderStatusEnum: int
{
    case PENDING_PAYMENT = 1;
    case SUCCESS = 2;
    case FAILED = 3;
}
