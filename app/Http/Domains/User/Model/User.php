<?php

namespace App\Http\Domains\User\Model;

use App\Http\Domains\Order\Model\Order;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected static function newFactory()
    {
        return UserFactory::new();
    }
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
