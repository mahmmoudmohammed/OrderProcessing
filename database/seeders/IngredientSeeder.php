<?php

namespace Database\Seeders;

use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Domains\EAV\Model\AttributeValue;
use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\Product;
use App\Http\Domains\Product\Model\ProductIngredient;
use App\Http\Domains\Project\Model\Project;
use App\Http\Domains\Project\Model\ProjectStatusEnum;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        Ingredient::create([
            'name' => 'Beef',
            'sku' => 'BEEF-001',
        ]);
        Ingredient::create([
            'name' => 'Cheese',
            'sku' => 'CHEESE-001',
        ]);
        Ingredient::create([
            'name' => 'Onion',
            'sku' => 'ONION-001',
        ]);
    }
}
