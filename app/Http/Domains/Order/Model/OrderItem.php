<?php

namespace App\Http\Domains\Order\Model;

use App\Http\Domains\Product\Model\MerchantIngredient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'merchant_product_id',
        'quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function getTotalPriceAttribute(): float|int
    {
        return $this->quantity * $this->price;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function merchantIngredient(): BelongsTo
    {
        return $this->belongsTo(MerchantIngredient::class);
    }

    public function restoreQuantities()
    {
        $item = $this->merchantIngredient();
        $item->increment($this->quantity);

        if($item->quantity < $item->threshold) {
            IngredientThresholdReachedJob::dispatchSync($item);
        }
    }

    public function decrement(int $qty)
    {
        $this->quantity -= max(0, $qty);
        if($this->quantity < $item->threshold) {
            IngredientThresholdReachedJob::dispatchSync($item);
        }
    }
}
