<?php

namespace App\Http\Domains\Order\DTO;


class OrderItemDto
{
    public function __construct(
        public readonly int $merchantProductId,
        public readonly int $quantity,
        public readonly float $price,
        public readonly float $total
    ) {
    }
}
