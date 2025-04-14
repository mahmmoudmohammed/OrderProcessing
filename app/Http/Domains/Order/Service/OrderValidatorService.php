<?php

namespace App\Http\Domains\Order\Service;

use App\Exceptions\InternalValidationException;
use App\Http\Domains\Order\DTO\OrderRequestDto;
use App\Http\Domains\Order\Repository\OrderRepository;
use App\Http\Domains\Product\Model\MerchantProduct;
use App\Http\Helpers\ApiDesignTrait;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class OrderValidatorService
{
    use ApiDesignTrait;

    /**
     * Validate order ingredients for sufficient stock
     *
     * @throws InternalValidationException
     */
    public function validateIngredients(OrderRequestDto $orderRequest): EloquentCollection
    {
        $itemIds = $orderRequest->merchantProducts->keys()->all();

        /** @var EloquentCollection<MerchantProduct> $merchantProducts */
        $merchantProducts = OrderRepository::getOrderItems($itemIds);

        foreach ($merchantProducts as $merchantProduct) {
            $this->validateMerchantProduct($merchantProduct, $orderRequest->merchantProducts);
        }

        return $merchantProducts;
    }

    /**
     * @throws InternalValidationException
     */
    protected function validateMerchantProduct(MerchantProduct $merchantProduct, Collection $orderProducts): void
    {
        if (!$merchantProduct->active) {
            $this->throwValidationException($merchantProduct->product->name . " product is not available at this time.");
        }

        foreach ($merchantProduct->merchantProductIngredients as $merchantProductIngredient) {
            $requiredQty = $merchantProductIngredient->quantity * $orderProducts[$merchantProduct->id]['quantity'];

            if ($requiredQty > $merchantProductIngredient->merchantIngredient->stock) {
                $this->throwValidationException("Insufficient quantity for product: " . $merchantProduct->product->name);
            }
            //TODO:: add Extra edge cases
        }
    }
}
