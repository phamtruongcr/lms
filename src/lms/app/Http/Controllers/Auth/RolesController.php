<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Role\CreateRequest;
use App\Http\Requests\Auth\Role\UpdateRequest;
use App\Models\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RolesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::select([
            'id',
            'slug',
            'name',
            'created_at',
            'updated_at',
        ])->paginate();
        return view('auth.role.index', compact('roles'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param createRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(CreateRequest $request)
    {
        $role = new Role();
        /** @phpstan-ignore-next-line  */
        $role->name = $request->name;
        /** @phpstan-ignore-next-line  */
        $role->slug = Str::slug($request->name);

        /**
         *  Permission Here
         */
        /** @phpstan-ignore-next-line  */
        $permissions = collect(json_decode($this->permissions($request)))->toArray();
        $role->permissions = $permissions;

        $role->save();

        Session::flash('success', __('auth.role_creation_successful'));
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int $id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Session::flash('failed', __('global.denied'));
            return redirect()->back();
        }

        /** @phpstan-ignore-next-line  */
        $permission = json_decode(json_encode($role->permissions), true);
        return view('auth.role.update', array(
            'dataDb'      => $role,
            'permissions' => $permission
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param updateRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(UpdateRequest $request, $id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Session::flash('failed', __('global.denied'));
            return redirect()->back();
        }
        /** @phpstan-ignore-next-line  */
        $role->name = $request->name;

        /**
         *  Permission Here
         */
        /** @phpstan-ignore-next-line  */
        $permissions = collect(json_decode($this->permissions($request)))->toArray();
        $role->permissions = $permissions;
        $role->save();

        Session::flash('success', __('auth.role_update_successful'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    /** @phpstan-ignore-next-line  */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        $id = $request->input('role_id', 0);
        /** @phpstan-ignore-next-line  */
        $role = Sentinel::findRoleById($id);

        if (empty($role)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('roles.index');
        }

        $role->users()
            ->detach($user);
        $role->delete();

        Session::flash('success', __('auth.delete_account'));

        return redirect()->route('roles.index');
    }

    /**
     * For Add Permission
     *
     * @param Request $request
     *
     * @return string
     */
    private function permissions(Request $request)
    {

        //Dashboard
        $permissions['dashboard'] = true;

        $request = $request->except(array('_token', 'name', '_method', 'previousUrl'));

        foreach ($request as $key => $value) {
            $permissions[preg_replace('/_([^_]*)$/', '.\1', $key)] = true;
        }

        /** @phpstan-ignore-next-line  */
        return json_encode($permissions);
    }

    /**
     * Duplicate Form
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    /** @phpstan-ignore-next-line  */
    public function duplicate($id)
    {
        $role = Role::where('id', $id)->firstOrFail();

        /** @phpstan-ignore-next-line  */
        $permission = json_decode(json_encode($role->permissions), true);

        return view('auth.role.duplicate', ['data' => $role, 'permissions' => $permission]);
    }
}
