<?php

namespace Database\Factories\Quizz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quizz\QuestionTranslation>
 */
class QuestionTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' =>fake()->text(50),
            'lang'=>'en',
        ];
    }
}
