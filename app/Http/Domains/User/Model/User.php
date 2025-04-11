<?php

namespace App\Http\Domains\User\Model;

use App\Http\Domains\Order\Model\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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

}
