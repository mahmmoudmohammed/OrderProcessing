<?php

namespace App\Http\Domains\Product\Model;

use App\Http\Domains\User\Model\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'merchant_id',
        'price',
        'active'
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function merchantProductIngredients(): HasMany
    {
        return $this->hasMany(MerchantProductIngredient::class);
    }

}
