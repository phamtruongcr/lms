<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Hashing\BcryptHasher;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class SentinelAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    /** @phpstan-ignore-next-line  */
    public function handle($request, Closure $next, $role=[])
    {
        /** @phpstan-ignore-next-line  */
        Sentinel::setHasher( new BcryptHasher() );

        $user = Sentinel::check();

        if ( !$user ) {
            return redirect()->guest( 'admin/login' );
        }

        /** @phpstan-ignore-next-line  */
        $roles = Sentinel::getRoles()->pluck('slug')->all();

        if( is_array( $roles ) ){
            if( in_array( 'admin', $roles ) ){
                return $next( $request );
            }
        }

        /** @phpstan-ignore-next-line  */
        if( $user->inRole( $role ) ){
            return $next( $request );
        }
        
        if( $request->ajax() || $request->wantsJson() ){
            
            /** @phpstan-ignore-next-line  */
            return response( trans( 'backpack::base.unauthorized' ) );
        }

        return abort(404, 'Unauthorized action.');        
    }
}
