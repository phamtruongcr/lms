<?php

namespace Database\Seeders;

use App\Models\Quizz\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Quizz\Question::factory()
        ->count(10)
        ->hasQuestionTranslations(1)
        ->create();
    
        $questions=Question::all();
        foreach($questions as $question)
        {
            $question->slug=Str::slug($question->translate('en')->content);
            $question->save();

        }
    }
}
