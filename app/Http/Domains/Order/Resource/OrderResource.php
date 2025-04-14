<?php

namespace App\Http\Domains\Order\Resource;
use App\Http\Domains\User\Resource\MerchantResource;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'serial_number' => $this->serial_number,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'notes' => $this->notes,
            'merchant' => MerchantResource::make($this->whenLoaded('merchant')),
            'items' => ItemResource::collection($this->whenLoaded('orderItems')),
            'user' => UserResource::make($this->whenLoaded('user')),

        ];
    }
}

