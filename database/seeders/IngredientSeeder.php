<?php

namespace Database\Seeders;

use App\Http\Domains\Product\Model\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        Ingredient::create([
            'name' => 'Beef',
        ]);
        Ingredient::create([
            'name' => 'Cheese',
        ]);
        Ingredient::create([
            'name' => 'Onion',
        ]);
    }
}
