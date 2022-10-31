<?php

namespace Database\Factories\Course;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->text(50);
        $slug = Str::slug($name);
        return [
            'slug'=>$slug,
            'status'=>fake()->numberBetween(0,1),
        ];
    }
}
