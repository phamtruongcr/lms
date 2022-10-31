<?php

namespace Database\Factories\Course;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course\CourseTranslation>
 */
class CourseTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->text(100);
        return [
            'name' => $name,
            'lang' => 'en',
            'description' => fake()->text(1000),
        ];
    }
}
