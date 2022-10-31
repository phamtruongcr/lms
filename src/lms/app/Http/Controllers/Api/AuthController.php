<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class AuthController extends Controller
{    
    /**
     * login
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $credentials = $request->all();
        try {
            $user = Sentinel::authenticate($credentials);
            if ($user) {
                return response()->json([
                    'success' => 'OK',
                    /** @phpstan-ignore-next-line  */
                    'token' => $user->createToken('$2y$10$DdhHAg.PDyDY0v7c94bbfeHvD9CEK13Cr41fnUEjBW2Kv.C/PbbqO')
                    ->accessToken,
                ], 200);
            } else {
                $msg = 'The provided credentials do not match our records.';
            }
        } catch (NotActivatedException $n) {
            $msg = 'The user is note activation';
        } catch (ThrottlingException $t) {
            $msg = 'The user is banded in '
                . round($t->getDelay() / 60) . ' minute';
        }

        return response()->json([
            'success' => 'NG',
            'msg' => $msg
        ], 406);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        //
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
