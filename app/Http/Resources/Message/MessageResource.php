<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\Type\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'is_ai' => $this->is_ai,
            'type' => TypeResource::make($this->type),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
