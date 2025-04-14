<?php

namespace App\Http\Domains\Product\Model;

use Database\Factories\MerchantProductIngredientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantProductIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_product_id',
        'merchant_ingredient_id',
        'quantity',
    ];

    protected static function newFactory()
    {
        return MerchantProductIngredientFactory::new();
    }
    public function merchantProduct(): BelongsTo
    {
        return $this->belongsTo(MerchantProduct::class);
    }

    public function merchantIngredient(): BelongsTo
    {
        return $this->belongsTo(MerchantIngredient::class);
    }

}
