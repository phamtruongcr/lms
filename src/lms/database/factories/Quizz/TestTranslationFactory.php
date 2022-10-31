<?php

namespace Database\Factories\Quizz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quizz\TestTranslation>
 */
class TestTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          'lang'=>'en',
          'name'=>fake()->text(50),
          'description'=>fake()->text(200),
        ];
    }
}
