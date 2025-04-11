<?php

namespace App\Http\Domains\User\Model;

use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Product\Model\Ingredient;
use App\Http\Domains\Product\Model\MerchantIngredient;
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
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function merchantIngredients(): HasMany
    {
        return $this->hasMany(MerchantIngredient::class);
    }
}
