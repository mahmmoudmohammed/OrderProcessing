<?php

namespace Database\Seeders;

use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\Product\Model\Product;
use App\Http\Domains\User\Model\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run()
    {
        $merchant = Merchant::create([
            'name' => 'merchant',
            'email' => 'merchant@example.test',
        ]);
        $Beef = Ingredient::where('name', 'Beef')->first()->id;
        $Cheese = Ingredient::where('name', 'Cheese')->first()->id;
        $Onion = Ingredient::where('name', 'Onion')->first()->id;
        $merchant->merchantIngredients()->createMany([
            [
                'ingredient_id' => $Beef,
                'stock' => 20000,
                'max_capacity' => 20000
            ], [
                'ingredient_id' => $Cheese,
                'stock' => 5000,
                'max_capacity' => 5000
            ], [
                'ingredient_id' => $Onion,
                'stock' => 1000,
                'max_capacity' => 1000
            ],
        ]);
        $merchant->merchantProducts()->create([
            'product_id' => Product::where('name', 'Burger')->first()->id,
            'price' => fake()->randomFloat(min: 20, max: 1000),
        ])->merchantProductIngredients()->createMany(
            [[
                'merchant_ingredient_id' => MerchantIngredient::where(['ingredient_id' => $Beef, 'merchant_id' => $merchant->id])->first()->id,
                'quantity' => 150,
            ], [
                'merchant_ingredient_id' => MerchantIngredient::where(['ingredient_id' => $Cheese, 'merchant_id' => $merchant->id])->first()->id,
                'quantity' => 30
            ], [
                'merchant_ingredient_id' => MerchantIngredient::where(['ingredient_id' => $Onion, 'merchant_id' => $merchant->id])->first()->id,
                'quantity' => 20,
            ]]
        );

    }
}
