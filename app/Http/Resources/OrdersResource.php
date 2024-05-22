<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->category_name,
            'user_id' => $this->user_id,
            'shipping_id' => $this->shipping_id,
            'user_payment_id' => $this->user_payment_id,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
          ];
    }
}
