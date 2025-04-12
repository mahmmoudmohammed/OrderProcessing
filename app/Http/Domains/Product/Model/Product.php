<?php

namespace App\Http\Domains\Product\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function merchantProducts(): HasMany
    {
        return $this->hasMany(MerchantProduct::class);
    }
}
