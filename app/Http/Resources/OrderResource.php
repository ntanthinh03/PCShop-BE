<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_code' => $this->order_code,
            'total_amount' => (float) $this->total_amount,
            'status' => $this->status,
            'shipping_address' => $this->shipping_address,
            'placed_at' => $this->created_at?->toISOString(),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
