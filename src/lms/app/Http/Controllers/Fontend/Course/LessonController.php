<?php

namespace App\Http\Controllers\Fontend\Course;

use App\Http\Controllers\Controller;
use App\Models\Course\Chapter;
use App\Models\Course\Course;
use App\Models\Course\Lesson;
use App\Models\Quizz\Test;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{

    /**
     * show
     *
     * @param  mixed $id
     * @param  mixed $chapter_id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function show($id, $chapter_id)
    {
        $user = Sentinel::getUser();

        $lesson = DB::table('student_lessons as sl')
            ->select([
                'lessons.id',
                'lt.name',
                'sl.progress',
                'lt.content'
            ])
            ->leftJoin('users', 'users.id', 'sl.student_id')
            ->rightJoin('lessons', 'sl.lesson_id', 'lessons.id')
            ->leftJoin('lesson_translations as lt', 'lt.lesson_id', 'lessons.id')
            /** @phpstan-ignore-next-line  */
            ->where('users.id', $user->id)
            ->where('sl.lesson_id', $id)
            ->where('sl.chapter_id', $chapter_id)
            ->first();

        if (isset($lesson)) {

            $files = DB::table('files')
            /** @phpstan-ignore-next-line  */
                ->where('lesson_id', $lesson->id)
                ->orderByDesc('type')
                ->get();

            $tests = Test::select([
                'tests.id',
                'slug',
                'tt.name'
            ])
                ->leftJoin('test_translations as tt', 'tt.test_id', 'tests.id')
                 /** @phpstan-ignore-next-line  */
                ->where('lesson_id', $lesson->id)
                ->get();

            $chapter = Chapter::find($chapter_id);

            $course = Course::select([
                'courses.id',
                'ct.name'
            ])
                ->leftJoin('course_translations as ct', 'ct.course_id', 'courses.id')
                /** @phpstan-ignore-next-line  */
                ->where('courses.id', $chapter->course_id)
                ->first();

            $chapters = Chapter::select([
                'chapters.id',
                'chapters.slug',
                'ct.name',
                'start_at',
                'finish_at',
                'created_at',
                'updated_at'
            ])
                ->with('lessons')
                ->leftJoin('chapter_translations AS ct', 'chapter_id', 'chapters.id')
                ->where('lang', $this->lang)
                /** @phpstan-ignore-next-line  */
                ->where('course_id', $course->id)
                ->paginate();

            return view('font_end.lessons.detail', compact('lesson', 'course', 'chapters', 'files', 'tests'));
        }
        
        return redirect(route('404'));
    }
}
