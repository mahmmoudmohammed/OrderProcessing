<?php

namespace App\Http\Domains\Product\Model;

use App\Http\Domains\User\Model\Merchant;
use Database\Factories\MerchantIngredientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'ingredient_id',
        'max_capacity',
        'stock',
    ];
    protected static function newFactory()
    {
        return MerchantIngredientFactory::new();
    }
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
    public function merchantProductIngredients(): HasMany
    {
        return $this->hasMany(MerchantProductIngredient::class);
    }
}
