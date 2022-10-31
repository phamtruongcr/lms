<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Models\Class\Clas;
use App\Models\Course\LessonTranslation;
use App\Models\Group\Group;
use App\Models\Role;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Builder\Class_;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
         $groups= Group::select(
            'name',
            'class.id',
            'class_manager_id',
            'users.first_name as manager_name',
            'groups.created_at',
            'groups.updated_at',
         )
         ->leftJoin('users','users.id','class_manager_id')
         ->orderBy('groups.id','desc')
         ->paginate();
        return view('class.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $class = new Clas();
        // $class_manager= ::where('lang',$this->lang);
        // ->pluck('name','class_manager_id	');
        $lessons = LessonTranslation::where('lang', $this->lang)
            ->pluck('name', 'lesson_id');
        if ($this->lang == 'vi') {
            $language = 'en';
        } else {
            $language = 'vi';
        }

        $roleDb = Role::select('id', 'name')
            ->get();


        return view('class.create', array(
            'roleDb' => $roleDb
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $manage = $request->manage;
        /** @phpstan-ignore-next-line  */
        $class  = Sentinel::getUser()['first_name'];
        DB::beginTransaction();

        try {
            $data = User::create([
                'name' => $request->first_name,
                /** @phpstan-ignore-next-line  */
                'manage'      => strtolower($manage),
                'created_by' => $class,
                'updated_by' => $class,
            ]);

            //Create a new user
            /** @phpstan-ignore-next-line  */
            $class = Sentinel::registerAndActivate($data);

            //Attach the user to the role
            /** @phpstan-ignore-next-line  */
            $role = Sentinel::findRoleById($request->role);
            $role->users()
                ->attach($class);

            DB::commit();
            Session::flash('success', __('auth.account_creation_successful'));
            return redirect()->route('clas.index');
        } catch (\Exception $exception) {
            DB::rollBack();

            Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }
    //     $request ->validate($request,[
    //         'name'=>'required|max:255',
    //         'manage'=>'required|max:255',
    //         'create_at ' => 'required|max:255',
    //     ]);
    // }


    // // }    DB::commit();
    // //      DB::rollBack();

    // //     Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());

    // //     return redirect()
    // //         ->back()
    // //         ->withInput($request->all());
    // // 



    /**
     * show
     *
     * @param  mixed $id
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $class = Clas::find($id);
        if ($class) {
            $class_manager = Clas::where('lang', $this->lang)
                ->pluck('name', 'class_manager_id');
/** @phpstan-ignore-next-line  */
            return view('admin.products.edit', compact('product', 'categories'));
        }

        return redirect(route('product.index'))
            ->with('msg', 'Product is not exitsting!');
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
        $msg = 'Product is not exitsting!';
        $class = Clas::find($id);
        if ($class) {
            /** @phpstan-ignore-next-line  */
            $class->name = $request->input('name');
            /** @phpstan-ignore-next-line  */
            $class->class_manager_id = $request->input('class_manager_id');
            /** @phpstan-ignore-next-line  */
            $class->created_at = $request->input('created_at');
            /** @phpstan-ignore-next-line  */
            $class->updated_at = $request->input('updated_at');
            $class->save();
            $msg = 'Update product is success!';
        }



        return redirect(route('product.index'))
            ->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $class_id = $request->input('class_id', 0);
        if ($class_id) {
            /** @phpstan-ignore-next-line  */
            Clas::destroy($class_id);
            return redirect(route('clas.index'))
                /** @phpstan-ignore-next-line  */
                ->with('msg', "Delete product {$class_id} success!");
        } else {

            return redirect(route('answer.index'))
                /** @phpstan-ignore-next-line  */
                ->with('warning_msg', "Can not delete answer {$class_id} ");
        }
    }
}
