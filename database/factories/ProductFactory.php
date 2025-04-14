<?php

namespace Database\Factories;

use App\Http\Domains\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence,
        ];
    }
}
