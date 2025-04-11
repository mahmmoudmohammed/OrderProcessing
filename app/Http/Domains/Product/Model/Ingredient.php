<?php

namespace App\Http\Domains\Product\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
    ];

    public function merchantIngredients(): HasMany
    {
        return $this->hasMany(MerchantIngredient::class);
    }
    public function productIngredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

}
