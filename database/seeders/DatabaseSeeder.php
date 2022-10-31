<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SebastianBergmann\LinesOfCode\Counter;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class
        ]);
        $this->call([
            CourseSeeder::class
        ]);
        $this->call([
            TestSeeder::class
        ]);
        $this->call([
            QuestionSeeder::class
        ]);
        $this->call([
            TypeSeeder::class
        ]);
        $this->call([
            LessonSeeder::class
        ]);
    }
}
