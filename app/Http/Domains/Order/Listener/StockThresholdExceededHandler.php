<?php

namespace App\Http\Domains\Order\Listener;

use App\Http\Domains\Order\Event\StockThresholdExceeded;
use App\Http\Domains\Order\Mail\StockThresholdExceeded as StockThresholdExceededMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StockThresholdExceededHandler implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockThresholdExceeded $event): void
    {
        Mail::to($event->merchantIngredient->merchant->email)
            ->send(new StockThresholdExceededMail($event->merchantIngredient->stock))
        ;
    }

    public function failed(\Throwable $exception)
    {
        Log::error("Failed to Send Merchant updates", [
            'exception' => $exception->getMessage()
        ]);
    }
}
