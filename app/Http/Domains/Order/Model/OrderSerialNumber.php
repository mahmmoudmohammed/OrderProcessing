<?php

namespace App\Http\Domains\Order\Model;

use App\Http\Domains\Product\Model\MerchantProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderSerialNumber extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
