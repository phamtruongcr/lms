<?php

namespace Database\Factories\Course;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course\Chapter>
 */
class ChapterFactory extends Factory
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
            'slug' => $slug,
            'start_at' => fake()->date('Y-m-d'),
            'finish_at' => fake()->date('Y-m-d'),
        ];
    }
}
