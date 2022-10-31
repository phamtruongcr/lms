<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    protected function redirectTo($request)
    {
        if(
            $request->expectsJson()
            || 'application/json' == $request->header('Content-Type')
            ){
                $response = ['error' => 'Bạn chưa truyền token hoặc token hết hạn'];

                throw new HttpResponseException(response()->json($response, 401));
        }

        // if (!$request->expectsJson()) {
        //     return route('login');
        // }
        return route('login');
    }
}
