<?php

namespace Database\Factories\Question;

use App\Models\Question\MainQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question\SubQuestion>
 */
class SubQuestionFactory extends Factory
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
            'main_question_id' => MainQuestion::inRandomOrder()->first(),
        ];
    }
}
