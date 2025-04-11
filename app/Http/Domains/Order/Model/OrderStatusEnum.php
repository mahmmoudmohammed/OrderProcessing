<?php

namespace App\Http\Domains\Order\Model;

enum OrderStatusEnum: int
{
    case DRAFT = 1;
    case PENDING = 2;
    case APPROVED = 3;
    case CANCELED = 4;
    public static function values(): array
    {
        return collect(OrderStatusEnum::cases())->pluck('value')->toArray();
    }
}
