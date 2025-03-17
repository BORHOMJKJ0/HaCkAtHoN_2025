<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\Type\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainQuestionResource extends JsonResource
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
            'text' => $this->text,
            'type' => TypeResource::make($this->type)
        ];
    }
}
