<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('register');
    }

    /**
     * Display a listing of the resource.
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        
        DB::beginTransaction();
        
        /** @phpstan-ignore-next-line  */
        try {

            $request->offsetSet('created_by', 'Register');
            $request->offsetSet('updated_by', 'Register');

            if ($user = Sentinel::register($request->all())) {

                /** @phpstan-ignore-next-line  */
                $activation = Activation::create($user);

                //Attach the user to the role
                /** @phpstan-ignore-next-line  */
                $role = Sentinel::findRoleBySlug('user');
                $role->users()
                    ->attach($user);

                /** @phpstan-ignore-next-line  */
                $code = $activation->code;
                $sent = Mail::send('auth.emails.activate', compact('user', 'code'), function ($m) use ($user) {
                    /** @phpstan-ignore-next-line  */
                    $m->to($user->email)
                        ->subject('Activate Your Account');
                });


                /** @phpstan-ignore-next-line  */
                if ($sent === 0) {
                    Session::flash('failed', __('auth.activation_email_unsuccessful'));

                    return redirect()
                        ->back()
                        ->withInput();
                }

                DB::commit();

                Session::flash('success', __('auth.activation_email_successful'));
                return redirect()->route('login');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage() . ' ' . $exception->getLine());
            /** @phpstan-ignore-next-line  */
            Session::flash('failed', __('auth.activation_email_unsuccessful'));
            return redirect()->route('register');
        }
    }

    /**
     * Display a listing of the resource.
     *@param int $userId
     *@param int $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($userId, $code)
    {
        
        /** @phpstan-ignore-next-line  */
        $user = Sentinel::findUserById($userId);
        /** @phpstan-ignore-next-line  */
        if (Activation::complete($user, $code)) {

            // Activation was successfull
            Session::flash('success', __('auth.activate_successful'));

            return redirect()->route('login');
        } else {

            Activation::removeExpired();
            // Activation not found or not completed.
            Session::flash('failed', __('auth.activate_unsuccessful'));

            return redirect()->route('register');
        }
    }
}
