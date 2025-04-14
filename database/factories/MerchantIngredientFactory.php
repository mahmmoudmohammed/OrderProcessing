<?php

namespace Database\Factories;

use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\User\Model\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantIngredientFactory extends Factory
{
    protected $model = MerchantIngredient::class;

    public function definition()
    {
        return [
            'merchant_id' => Merchant::factory(),
            'ingredient_id' => Ingredient::factory(),
            'max_capacity' => $this->faker->numberBetween(100, 1000),
            'stock' => $this->faker->numberBetween(50, 500),
        ];
    }
}
