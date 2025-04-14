<?php

namespace App\Http\Domains\Order\Event;

use App\Http\Domains\Product\Model\MerchantIngredient;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockThresholdExceeded implements ShouldDispatchAfterCommit
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public MerchantIngredient $merchantIngredient)
    {

    }

}
