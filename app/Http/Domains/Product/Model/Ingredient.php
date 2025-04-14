<?php

namespace App\Http\Domains\Product\Model;

use Database\Factories\IngredientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    protected static function newFactory()
    {
        return IngredientFactory::new();
    }
    public function merchantIngredients(): HasMany
    {
        return $this->hasMany(MerchantIngredient::class);
    }

}
