<?php

namespace App\Http\Domains\Order\DTO;

use Illuminate\Support\Collection;
class OrderRequestDto
{
    public readonly Collection $merchantProducts;
    public readonly string $notes;

    public function __construct(
        array $orderDetails
    ) {
        $this->merchantProducts = collect($orderDetails['merchant_products'] ?? [])
            ->keyBy('id');
        $this->notes = $orderDetails['notes'] ?? null;
    }
}
