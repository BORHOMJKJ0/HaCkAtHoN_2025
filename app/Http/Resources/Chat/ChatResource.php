<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->diffForHumans(),
        ];
        if ($request->routeIs('chats.show')) {
            $data['messages'] = MessageResource::collection(
                $this->messages()->orderBy('created_at', 'desc')->get()
            );
        }

        return $data;
    }
}
