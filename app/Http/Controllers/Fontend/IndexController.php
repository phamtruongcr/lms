<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Models\Course\Course;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Sentinel::getUser();

        if ($user) {
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
                ->paginate(9);
        } else {
            $courses = Course::select([
                'courses.id',
                'ct.name',
                'images.name as name_image',
                'slug',
                'start_at',
                'finish_at',
            ])
                ->leftJoin('course_translations AS ct', 'course_id', 'courses.id')
                ->leftJoin('images', 'images.id', 'courses.image_id')
                ->where('lang', $this->lang)
                ->paginate(9);
        }

        return view('home', compact('courses'));
    }
}
