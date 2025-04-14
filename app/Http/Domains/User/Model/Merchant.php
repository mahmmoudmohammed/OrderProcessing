<?php

namespace App\Http\Domains\User\Model;

use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\MerchantIngredient;
use App\Http\Domains\Product\Model\MerchantProduct;
use Database\Factories\MerchantFactory;
use Database\Factories\MerchantProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Merchant extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
    ];
    protected static function newFactory()
    {
        return MerchantFactory::new();
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function merchantIngredients(): HasMany
    {
        return $this->hasMany(MerchantIngredient::class);
    }
    public function merchantProducts(): HasMany
    {
        return $this->hasMany(MerchantProduct::class);
    }
}
