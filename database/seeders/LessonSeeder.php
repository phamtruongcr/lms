<?php

namespace Database\Seeders;

use App\Models\Course\Lesson;
use App\Models\Quizz\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lessons')->truncate();
        DB::table('lesson_translations')->truncate();
        DB::table('answers')->truncate();
        DB::table('answer_translations')->truncate();
        
        \App\Models\Course\Lesson::factory()
        ->count(10)
        ->has(
            Answer::factory()
            ->count(4)
            ->hasAnswerTranslations(1)
        )
        ->hasFiles(2)
        ->hasLessonTranslations(1)
        ->create();
        
        $lessons=Lesson::all();
        foreach($lessons as $lesson)
        {
            $lesson->slug=Str::slug($lesson->translate('en')->name);
            $lesson->save();

        }
    }
}
