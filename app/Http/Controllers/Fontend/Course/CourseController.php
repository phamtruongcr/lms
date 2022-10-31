<?php

namespace App\Http\Controllers\Fontend\Course;

use App\Http\Controllers\Controller;
use App\Models\Course\Chapter;
use App\Models\Course\Course;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Sentinel::getUser();

        $courses = DB::table('group_students AS gs')
            ->select([
                'courses.id',
                'courses.start_at',
                'courses.finish_at',
                'groups.name as name_group',
                'ct.name as name',
                'images.name as name_image'
            ])
            ->leftJoin('users', 'users.id', 'gs.student_id')
            ->rightJoin('group_courses as gc', 'gs.class_id', 'gc.class_id')
            ->join('courses', 'gc.course_id', 'courses.id')
            ->leftJoin('groups', 'groups.id', 'gs.class_id')
            ->leftJoin('course_translations as ct', 'ct.course_id', 'courses.id')
            ->leftJoin('images', 'images.id', 'courses.image_id')
            /** @phpstan-ignore-next-line  */
            ->where('users.id', $user->id)
            ->paginate(8);
        return view('font_end.courses.index', compact('courses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * 
     *  @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = Sentinel::getUser();

        $courses = DB::table('group_students AS gs')
            ->select([
                'courses.id',
                'groups.name as name_group',
                'groups.id as group_id',
                'courses.start_at',
                'courses.finish_at',
                'ct.name as name',
                'ct.description',
                'images.name as name_image',
                'courses.start_at',
                'courses.finish_at'
            ])
            ->leftJoin('users', 'users.id', 'gs.student_id')
            ->rightJoin('group_courses as gc', 'gs.class_id', 'gc.class_id')
            ->join('courses', 'gc.course_id', 'courses.id')
            ->leftJoin('groups', 'groups.id', 'gs.class_id')
            ->leftJoin('course_translations as ct', 'ct.course_id', 'courses.id')
            ->leftJoin('images', 'images.id', 'courses.image_id')
            /** @phpstan-ignore-next-line  */
            ->where('users.id', $user->id)
            ->get();

        foreach ($courses as $item_course) {
            /** @phpstan-ignore-next-line  */
            if ($id == $item_course->id) {
                $course = $item_course;
            }
        }

        if (isset($course)) {
            $chapters = Chapter::select([
                'chapters.id',
                'chapters.slug',
                'ct.name',
                'start_at',
                'finish_at',
                'created_at',
                'updated_at'
            ])
                ->with(['lessons'])
                ->leftJoin('chapter_translations AS ct', 'chapter_id', 'chapters.id')
                ->where('lang', $this->lang)
                /** @phpstan-ignore-next-line  */
                ->where('chapters.course_id', $course->id)
                ->get();

            return view('font_end.courses.detail', compact('course', 'chapters', 'courses'));
        }
        return redirect(route('404'));
    }
}
