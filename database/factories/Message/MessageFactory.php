<?php

namespace Database\Factories\Message;

use App\Models\Chat\Chat;
use App\Models\Type\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message' => $this->faker->realtext(),
            'is_ai' => fake()->boolean(),
            'chat_id' => Chat::inRandomOrder()->first(),
            'type_id' => Type::inRandomOrder()->first(),
        ];
    }
}
