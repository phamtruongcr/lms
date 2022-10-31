<?php

namespace Database\Seeders;

use App\Models\Course\Chapter;
use App\Models\Course\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_translations')->truncate();
        DB::table('chapter_translations')->truncate();
        DB::table('courses')->truncate();
        DB::table('chapters')->truncate();
        Course::factory()
                    ->count(10)
                    ->has(
                        Chapter::factory()
                        ->count(2)
                        ->hasChapterTranslations(1)
                    )
                    ->hasCourseTranslations(1)
                    ->create();

        $courses = Course::all();
        foreach($courses as $course){
            $course->slug = Str::slug($course->translate('en')->name);
            $course->save();
        }

        $chapters = Chapter::all();
        foreach($chapters as $chapter){
            $chapter->slug = Str::slug($chapter->translate('en')->name);
            $chapter->save();
        }
    }
}
