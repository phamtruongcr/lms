<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Display a listing of the resource.
     * @param LoginRequest $request
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        

        try {
            $remember = $request->remember == '1' ? true : false;
            if (Sentinel::authenticate($request->all(), $remember)) {
                return redirect()->intended(route('dashboard'));
            } else {
                $msg = "The provided credentials do not match our records.";
            }
        } catch (NotActivatedException $e) {
            $msg = "Account not activated";
        } catch (ThrottlingException $e) {
            $delay = round($e->getDelay()/60);
            $msg = "Account banded {$delay} minutes";
        }
        return back()->withErrors([          
            'email' => $msg,
        ])->onlyInput('email');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function font_login()
    {
        return view('font_end/login');
    }

    /**
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function font_postLogin(LoginRequest $request)
    {
        try {
            $remember = $request->remember == '1' ? true : false;
            if (Sentinel::authenticate($request->all(), $remember)) {
                return redirect()->intended(route('home'));
            } else {
                $msg = "The provided credentials do not match our records.";
            }
        } catch (NotActivatedException $e) {
            $msg = "Account not activated";
        } catch (ThrottlingException $e) {
            $delay = round($e->getDelay()/60);
            $msg = "Account banded {$delay} minutes";
        }
        
        return back()->withErrors([            
            'email' => $msg,
        ])->onlyInput('email');
    }
}
