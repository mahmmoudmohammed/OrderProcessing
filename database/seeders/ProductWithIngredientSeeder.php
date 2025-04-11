<?php

namespace Database\Seeders;

use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\Product;
use App\Http\Domains\Product\Model\ProductIngredient;
use Illuminate\Database\Seeder;

class ProductWithIngredientSeeder extends Seeder
{
    public function run()
    {
        $product = Product::create([
            'name' => 'burger',
            'price' => 15.15,
        ]);
        ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => Ingredient::where('sku', 'BEEF-001')->first()->id,
            'quantity' => 150,
        ]);ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => Ingredient::where('sku', 'CHEESE-001')->first()->id,
            'quantity' => 30,
        ]);ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => Ingredient::where('sku', 'ONION-001')->first()->id,
            'quantity' => 20,
        ]);
    }
}
