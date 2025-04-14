<?php

declare(strict_types=1);

namespace App\Http\Domains\Order;

use App\Http\Domains\Order\Contract\OrderRepositoryInterface;
use App\Http\Domains\Order\Event\StockThresholdExceeded;
use App\Http\Domains\Order\Listener\StockThresholdExceededHandler;
use App\Http\Domains\Order\Repository\OrderRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot()
    {
        // MerchantIngredient::observe(MerchantIngredientObserver::class);

        Event::listen(StockThresholdExceeded::class, StockThresholdExceededHandler::class);
    }
}
