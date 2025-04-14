<?php

namespace Database\Factories;

use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\Product\Model\MerchantProduct;
use App\Http\Domains\Product\Model\MerchantProductIngredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantProductIngredientFactory extends Factory
{
    protected $model = MerchantProductIngredient::class;

    public function definition()
    {
        return [
            'merchant_product_id' => MerchantProduct::factory(),
            'merchant_ingredient_id' => MerchantIngredient::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
