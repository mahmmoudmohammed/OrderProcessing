<?php

namespace App\Http\Domains\Order\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notes' => 'nullable|string',
            'merchant_products' => 'required|array|min:1',
            'merchant_products.*.id' => 'required|exists:merchant_products,id',
            'merchant_products.*.quantity' => 'required|integer|min:1',
        ];
    }
}
