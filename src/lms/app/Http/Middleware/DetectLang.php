<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    /** @phpstan-ignore-next-line  */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('lang'))
        {
            $lang = $request->lang;
            /** @phpstan-ignore-next-line  */
            app()->setLocale($lang);
            $response = $next($request);
            /** @phpstan-ignore-next-line  */
            return $response->withCookie(cookie()->forever('lang', $lang));
        }else
        {
            $lang = $request->cookie('lang', 'en');
            /** @phpstan-ignore-next-line  */
            app()->setLocale($lang);
            return $next($request);
        }
    }
}
