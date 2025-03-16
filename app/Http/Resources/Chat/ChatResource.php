<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'guest_name' => $this->guest_name,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
