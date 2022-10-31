<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentResquest;
use App\Jobs\SendEmail;
use App\Mail\CowellMail;
use App\Models\Course\Course;
use App\Models\Group\Group;
use App\Models\Role;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //
        $students = User::select([
            'users.id',
            'ru.user_id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'address',
            'last_login',
            'users.created_at',

        ])
            ->leftJoin('role_users as ru', 'users.id', 'ru.user_id')
            ->where('ru.role_id', 2)
            ->paginate();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        $roleDb = Role::select('id', 'name')
            ->get();


        return view('admin.students.create', array(
            'roleDb' => $roleDb,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StudentResquest $request

     * @return \Illuminate\Http\RedirectResponse 

     */
    public function store(StudentResquest $request)
    {
        $email = $request->email;
        /** @phpstan-ignore-next-line  */
        $student  = Sentinel::getUser()['first_name'];
        DB::beginTransaction();


        try {
            $data = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
                'birthday'   => $request->birthday,
                'address'    => $request->address,
                /** @phpstan-ignore-next-line  */
                'email'      => strtolower($email),
                'password'   => "1234567@",
                'created_by' => $student,
                'updated_by' => $student,
            ];

            //Create a new user
            $student = Sentinel::registerAndActivate($data);

            //Attach the user to the role
            /** @phpstan-ignore-next-line  */
            $role = Sentinel::findRoleBySlug('user');
            $role->users()
                ->attach($student);

            $message = [
                'type' => 'Create account',
                'task' => $student->email,
                'content' => 'has been created account with password: '.$data['password'].' !',
            ];

            $students[] = $student;

            SendEmail::dispatch($message, $students);

            DB::commit();

            Session::flash('success', __('auth.account_creation_successful'));

            return redirect()->route('student.index');
        } catch (\Exception $exception) {
            DB::rollBack();

            Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {

        $students = User::find($id);
        $details = Course::select([
            'courses.id',
            'chapters.id as c_id',
            'ct.name',
            'sl.student_id',
            'sl.progress'
        ])
            ->join('course_translations as ct', 'courses.id', 'ct.course_id')
            ->join('chapters', 'courses.id', 'chapters.course_id')
            ->rightJoin('student_lessons as sl', 'sl.chapter_id', 'chapters.id')
            ->where('sl.student_id', $id)
            ->paginate();

        return view('admin.students.show', compact('students', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        /** @phpstan-ignore-next-line  */
        $student = Sentinel::findUserById($id);
        if (empty($student)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('student.index');
        }
        return view('admin.students.edit', array(
            'data'     => $student,

        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        /** @phpstan-ignore-next-line  */
        $student = Sentinel::findUserById($id);

        if (empty($student)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('admin.student.index');
        }

        DB::beginTransaction();
        try {
            //code...
            $credentials = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'  => $request->phone,
                'birthday'  => $request->birthday,
                'address'  => $request->address,
                'email'  => $request->email,
            ];

            #If User Input Password
            if ($request->password) {
                $validator = Validator::make($request->all(), [
                    'password' => 'min:8',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $credentials['password'] = $request->password;
            }
            /** @phpstan-ignore-next-line  */
            Sentinel::update($student, $credentials);

            DB::commit();

            Session::flash('success', __('auth.update_successful'));

            return redirect()->route('student.index');
        } catch (\Throwable $exception) {
            //throw $th;
            DB::rollBack();

            Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $student_id = $request->input('student_id', 0);
        if ($student_id) {
            /** @phpstan-ignore-next-line  */
            User::destroy($student_id);
            return redirect(route('student.index'))

                /** @phpstan-ignore-next-line  */
                ->with('msg', "Delete student {$student_id} success!");
        } else {
            throw new ModelNotFoundException();
        }
    }

    public function addStudents()
    {
        $students = DB::table('users')
            ->leftJoin('role_users as ru', 'users.id', 'ru.user_id')
            ->where('ru.role_id', 2)
            ->pluck('users.id', 'users.email');
        $managers = DB::table('users')
            ->leftJoin('role_users as ru', 'users.id', 'ru.user_id')
            ->where('ru.role_id', 4)
            ->pluck('users.id', 'users.email');
        return view('admin.students.addstudent', compact('students', 'managers'));
    }

    public function storeStudents(Request $request)
    {

        $list_student = explode(',', $request->students);

        foreach($list_student as $id_student){
            $student = User::find($id_student);
            $students[] = $student;
        }

        $group = Group::create([
            'name' => $request->class_name,
            'slug' => Str::slug($request->class_name),
            'class_manager_id' => $request->class_manager_id,
        ]);

        $group->students()->attach($list_student);
        
        $message = [
            'type' => 'Add Group',
            'task' => $request->class_name,
            'content' => 'You ok',
        ];
        
        SendEmail::dispatch($message, $students);

        return redirect()->route('student.index');
    }
}
