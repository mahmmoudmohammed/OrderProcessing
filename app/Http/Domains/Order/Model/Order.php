<?php

namespace App\Http\Domains\Order\Model;

use App\Http\Domains\User\Model\Merchant;
use App\Http\Domains\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'user_id',
        'merchant_id',
        'total_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status' => OrderStatusEnum::class,
    ];

    public function orderSerialNumber(): HasOne
    {
        return $this->hasOne(OrderSerialNumber::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

}
