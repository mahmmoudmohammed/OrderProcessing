<?php

namespace Database\Seeders;

use App\Http\Domains\Product\Model\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Burger',
            'description' => fake()->text(),
        ]);
        Product::create([
            'name' => 'Fried chicken',
            'description' => fake()->text(),
        ]);
    }
}
