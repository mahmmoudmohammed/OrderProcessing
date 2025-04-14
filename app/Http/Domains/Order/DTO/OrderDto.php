<?php

namespace App\Http\Domains\Order\DTO;

use App\Http\Domains\Order\Model\OrderStatusEnum;
use Illuminate\Support\Collection;

class OrderDto
{
    public function __construct(
        public readonly int $userId,
        public readonly int $merchantId,
        public readonly float $totalAmount,
        public readonly OrderStatusEnum $status,
        public readonly ?string $notes,
        public readonly Collection $items
    ) {
    }
}
