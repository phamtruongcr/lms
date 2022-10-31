<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\CreateRequest;
use App\Http\Requests\Auth\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::select([
            'users.id',
            'first_name',
            'last_name',
            'email',
            'last_login',
            'users.created_at',
            'users.updated_at',
        ])
        ->with('roles', 'activations')
        ->paginate();
        return view('auth.user.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roleDb = Role::select('id', 'name')
            ->get();

        return view('auth.user.create', array(
            'roleDb' => $roleDb,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(CreateRequest $request)
    {
        $email = $request->email;
        /** @phpstan-ignore-next-line  */
        $user  = Sentinel::getUser()['first_name'];

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
                'password'   => $request->password,
                'created_by' => $user,
                'updated_by' => $user,
            ];

            //Create a new user
            $user = Sentinel::registerAndActivate($data);

            //Attach the user to the role
            /** @phpstan-ignore-next-line  */
            $role = Sentinel::findRoleById($request->role);
            $role->users()
                ->attach($user);

            DB::commit();

            Session::flash('success', __('auth.account_creation_successful'));

            return redirect()->route('users.index');
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
     * @param int $id
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        /** @phpstan-ignore-next-line  */
        $user = Sentinel::findUserById($id);

        if (empty($user)) {
            Session::flash('failed', __('global.not_found'));
            return redirect()->route('users.index');
        }

        $roleDb = Role::select('id', 'name')
            ->get();

        $userRole = $user->roles[0]->id ?? null;
        return view('auth.user.update', array(
            'data'     => $user,
            'roleDb'   => $roleDb,
            'userRole' => $userRole
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(UpdateRequest $request, $id)
    {
        /** @phpstan-ignore-next-line  */
        $user = Sentinel::findUserById($id);

        if (empty($user)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('users.index');
        }

        DB::beginTransaction();
        try {
            /** @phpstan-ignore-next-line  */
            $oldRole = Sentinel::findRoleById($user->roles[0]->id ?? null);

            $credentials = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
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

            #Valid User For Update
            /** @phpstan-ignore-next-line  */
            $role = Sentinel::findRoleById($request->role);

            if ($oldRole) {
                #Remove a user from a role.
                $oldRole->users()
                    ->detach($user);
            }

            #Assign a user to a role.
            $role->users()
                ->attach($user);

            #Update User
            /** @phpstan-ignore-next-line  */
            Sentinel::update($user, $credentials);

            DB::commit();

            Session::flash('success', __('auth.update_successful'));

            return redirect()->route('users.index');
        } catch (\Exception $exception) {
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
     * @param  request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    /** @phpstan-ignore-next-line  */
    public function destroy(Request $request)
    {
        $id = $request->input('user_id', 0);
        /** @phpstan-ignore-next-line  */
        $user = Sentinel::findById($id);

        if (empty($user)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('users.index');
        }

        $user->delete();

        Session::flash('success', __('auth.delete_account'));

        return redirect()->route('users.index');
    }

    /**
     * For Active or Deactive User
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    /** @phpstan-ignore-next-line  */
    public function status($id)
    {
        /** @phpstan-ignore-next-line  */
        $user = Sentinel::findById($id);

        $activation = Activation::completed($user);

        #Remove activation code
        Activation::remove($user);

        if ($activation !== false) {
            #Deactivated This Activation
            /** @phpstan-ignore-next-line  */
            if ($user->id === Sentinel::getUser()->id) {
                Session::flash('failed', __('auth.deactivate_current_user_unsuccessful'));

                return redirect()->route('users.index');
            }

            Session::flash('success', __('auth.deactivate_successful'));

            return redirect()->back();
        }

        #Own User Cannot Change The User Status
        /** @phpstan-ignore-next-line  */
        if ($user->id === Sentinel::getUser()->id) {
            Session::flash('failed', __('auth.active_current_user_unsuccessful'));

            return redirect()->back();
        }

        #Get Activation Code
        $activationCreate = Activation::create($user);
        
        #Activate this account
        /** @phpstan-ignore-next-line  */
        Activation::complete($user, $activationCreate->code);

        Session::flash('success', __('auth.activate_successful'));

        return redirect()->back();
    }
}
