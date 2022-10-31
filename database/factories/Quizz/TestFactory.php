<?php

namespace Database\Factories\Quizz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quizz\Test>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'lesson_id'=>fake()->numberBetween(1,30),
            'slug'=>fake()->text(50),
            'total_point'=>fake()->randomFloat(2,50,60),
            'total_time'=>60,
            'limit'=>10,
            'status'=>0,
            'start_at' => fake()->datetime('Y-m-d H:i:s'),
            'finish_at' => fake()->datetime('Y-m-d H:i:s'),
        ];
    }
}
