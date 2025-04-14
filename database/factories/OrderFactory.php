<?php

namespace Database\Factories;

use App\Http\Domains\Order\Model\Order;
use App\Http\Domains\Order\Model\OrderStatusEnum;
use App\Http\Domains\User\Model\Merchant;
use App\Http\Domains\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'merchant_id' => Merchant::factory(),
            'total_amount' => $this->faker->randomFloat(2, 20, 500),
            'status' => OrderStatusEnum::PENDING_PAYMENT,
            'notes' => $this->faker->sentence,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $serialNumber = $order->orderSerialNumber()->create();
            $order->serial_number = $serialNumber->id;
            $order->save();
        });
    }
}
