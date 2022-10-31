<?php

namespace Database\Seeders;

use App\Models\Quizz\Test;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tests')->truncate();
        DB::table('test_translations')->truncate();
        \App\Models\Quizz\Test::factory()
        ->count(10)
        ->hasTestTranslations(1)
        ->create();

        $tests=Test::all();
        foreach($tests as $tests)
        {
            $tests->slug=Str::slug($tests->translate('en')->name);
            $tests->save();

        }

    }
}
