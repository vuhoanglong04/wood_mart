<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'full_name' => $this->full_name,
            'address'=>$this->address,
            'img' => $this->img,
            'group' => $this->group,
            'status' => $this->status,
            'is_online' => $this->is_online
          ];
    }
}
