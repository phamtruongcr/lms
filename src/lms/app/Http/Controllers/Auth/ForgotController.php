<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ForgotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function forgotPassword() {
        return view('auth.password.forgot');
    }
    
    /**
     * Send the given user's email reset instruction.
     *
     * @param forgotPasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processForgotPassword(ForgotPasswordRequest $request) {
    
        DB::beginTransaction();
        try {
            $credentials = [
                'login' => $request->email,
            ];
    
            
            /** @phpstan-ignore-next-line  */
            $user = Sentinel::findByCredentials($credentials);
    
            if (!$user) {
        
                Session::flash('failed', __('auth.forgot_password_email_not_found'));
        
                return redirect()->back()
                                 ->withInput();
            }
    
            $reminder = Reminder::exists($user) ?: Reminder::create($user);
            
            /** @phpstan-ignore-next-line  */
            $code     = $reminder->code;
    
            $sent     = Mail::send('auth.emails.password', compact('user', 'code'), function ($m) use ($user) {
                $m->to($user->email)
                  ->subject('Reset your account password.');
            });

            
            /** @phpstan-ignore-next-line  */
            if ($sent === 0) {
                Session::flash('failed', __('auth.forgot_password_unsuccessful'));

                return redirect()->back();

            }
    
            DB::commit();
    
            Session::flash('success', __('auth.forgot_password_successful'));
            return redirect()->back();
            
            
        } catch (\Exception $exception) {
            DB::rollBack();
    
            Session::flash('failed', __('auth.forgot_password_unsuccessful'));
    
            return redirect()->back();
    
        }
        
    }

     /**
     * Display the password reset view for the given token.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPassword(){
        return view('auth.password.reset');
    }
    
    /**
     * Reset the given user's password.
     *
     * @param ResetPasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processResetPassword(ResetPasswordRequest $request){
        
        /** @phpstan-ignore-next-line  */
        $user = Sentinel::findById($request->userId);
    
        if ( ! $user)
        {
            Session::flash('failed', __('auth.forgot_password_email_not_found'));
            return redirect()->back()
                           ->withInput();
        }
        
        /** @phpstan-ignore-next-line  */
        if ( ! Reminder::complete($user, $request->code, $request->password))
        {
            Session::flash('failed', __('Invalid or expired reset code.'));
    
            return redirect()->route('forgotPassword');
        }
    
        Session::flash('success', __('auth.password_change_successful'));
    
        return redirect()->route('login');
    
    }
    
    /**
     * Display the denied view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accessDenied(){
        return view('auth.password.change');
    }
    
    /**
     * Display the change password form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword(){
        return view('auth.password.change');
    }
    
    /**
     * Handle change password action
     *
     * @param changePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processChangePassword(ChangePasswordRequest $request){

        $user = Sentinel::getUser();
        
        $credentials = [
            /** @phpstan-ignore-next-line  */
            'email'    => $user->email,
            'password' => $request->old_password,
        ];
    
        #Is this password is valid for this user?
        
        /** @phpstan-ignore-next-line  */
        if(Sentinel::validateCredentials($user, $credentials)){
            $credentials['password'] = $request->password;
           
            
            /** @phpstan-ignore-next-line  */
            Sentinel::update($user, $credentials);
    
            Sentinel::logout();
    
            Session::flash('success', __('auth.password_change_successful'));
            return redirect()->route('login');
            
        } else {
            Session::flash('failed', __('auth.reset_password_change_unsuccessful_old'));
            return redirect()->back()->withInput($request->all());
        }
    }
}
