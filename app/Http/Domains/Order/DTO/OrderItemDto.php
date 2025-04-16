<?php

namespace App\Http\Domains\Order\DTO;


use App\Http\Domains\Product\Model\MerchantProduct;

class OrderItemDto
{
    public function __construct(
        public readonly MerchantProduct $merchantProduct,
        public readonly int $quantity,
        public readonly float $price,
        public readonly float $total
    ) {
    }
}
