<?php

namespace App\Http\Controllers\Admin\Group;

use App\Http\Controllers\Controller;

use App\Http\Requests\Student\AddCourseRequest;
use App\Models\Course\Chapter;
use App\Models\Course\Course;
use App\Models\Course\Lesson;
use App\Models\Group\Group;
use App\Models\Group\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        
        $datas= Group::select(
            'name',
            'groups.id',
            'class_manager_id',
            'users.first_name as manager_name',
            'groups.created_at',
            'groups.updated_at',
         )
         ->leftJoin('users','users.id','class_manager_id')
         ->orderBy('groups.id','desc')
         ->paginate();

        return view('admin.group.indexGroup', compact('datas'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $teacherDB = User::select([
            'users.id',
            'ru.user_id',
            'first_name',
            

        ])
        ->leftJoin('role_users as ru', 'users.id', 'ru.user_id')
        ->where('ru.role_id', 3)
        ->paginate();

         $groupDB = Group::select([
            'id',
            'name',

         ])->get();
 
         $courseDB = Course::select([
             
             'courses.id',
             'ct.name',
 
         ])
         ->join('course_translations as ct','courses.id', 'ct.course_id' )
         ->get();

        return view('admin.group.formCourse',compact('courseDB','groupDB','teacherDB'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddCourseRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(AddCourseRequest $request)
    {
        
        $class_id = $request->input('group');
        $course_id = $request->input('course');
        $teacher_id = $request->input('teacher');
        DB::beginTransaction();

        try {

            DB::table('group_courses')
            ->insert([
                'class_id'=>$class_id,
                'course_id'=>$course_id,
                'teacher_id'=>$teacher_id,
            ]);
            $students=DB::table('group_students')
            ->where('class_id',$class_id)
            ->pluck('id');
            $chapters=Chapter::where('course_id',$course_id)
            ->pluck('id');
            foreach($chapters as $chapter_id){
                $lessons=DB::table('chapter_lessons')
                ->where('chapter_id',$chapter_id)
                ->pluck('lesson_id');
                foreach($lessons as $lesson_id){
                        $lesson=Lesson::find($lesson_id);
                        $lesson->students()->attach($students,['chapter_id'=>$chapter_id,'progress'=>0]);
                }

            }
            DB::commit();
        } catch (\Throwable $t) {
            //throw $th;
            DB::rollBack();
            throw new ModelNotFoundException();
        }
       
        
        return redirect()->route('group.index');
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
