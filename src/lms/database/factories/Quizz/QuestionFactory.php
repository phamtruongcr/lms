<?php

namespace Database\Factories\Quizz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quizz\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type'=>fake()->numberBetween(1,3),
            'point'=>fake()->randomFloat(2,0,10),
            'slug'=>fake()->text(50),
            'lesson_id'=>fake()->numberBetween(1,30),
        ];
    }
}
