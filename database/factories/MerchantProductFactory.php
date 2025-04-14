<?php

namespace Database\Factories;

use App\Http\Domains\Product\Model\MerchantProduct;
use App\Http\Domains\Product\Model\Product;
use App\Http\Domains\User\Model\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantProductFactory extends Factory
{
    protected $model = MerchantProduct::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'merchant_id' => Merchant::factory(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'active' => true,
        ];
    }
}
