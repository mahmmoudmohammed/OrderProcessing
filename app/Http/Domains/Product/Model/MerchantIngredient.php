<?php

namespace App\Http\Domains\Product\Model;

use App\Http\Domains\User\Model\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'ingredient_id',
        'quantity',
    ];

    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

}
