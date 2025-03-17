<?php

namespace Database\Factories\Question;

use App\Models\Chat\Chat;
use App\Models\Type\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question\MainQuestion>
 */
class MainQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->text(),
            'chat_id' => Chat::inRandomOrder()->first(),
            'type_id' => Type::inRandomOrder()->first(),
        ];
    }
}
