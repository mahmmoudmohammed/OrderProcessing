<?php

namespace Database\Seeders;

use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\User\Model\Merchant;
use Illuminate\Database\Seeder;

class MerchantWithIngredientSeeder extends Seeder
{
    public function run()
    {
        $merchant1 = Merchant::create([
            'name' => 'first Merchant',
        ]);
        $merchant2 = Merchant::create([
            'name' => 'second Merchant',
        ]);

        $ingredientsData = [
            ['ingredient' => Ingredient::where('sku', 'BEEF-001')->first()->id, 'quantity' => 10000],
            ['ingredient' => Ingredient::where('sku', 'CHEESE-001')->first()->id, 'quantity' => 2500],
            ['ingredient' => Ingredient::where('sku', 'ONION-001')->first()->id, 'quantity' => 500],
        ];

            foreach ($ingredientsData as $data) {
                MerchantIngredient::create([
                    'merchant_id' => $merchant1->id,
                    'ingredient_id' => $data['ingredient'],
                    'quantity' => $data['quantity'],
                ]);
                MerchantIngredient::create([
                    'merchant_id' => $merchant2->id,
                    'ingredient_id' => $data['ingredient'],
                    'quantity' => $data['quantity'],
                ]);
            }
        }
    }
