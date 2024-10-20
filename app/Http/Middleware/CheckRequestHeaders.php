<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Config;

class CheckRequestHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $appHeaders = [
            'ip'         => $request->ip(),
            'lang'       => $request->header('lang'),
        ];

        Config::set('app_header', array_merge(config('app_header'), $appHeaders));
        app()->setLocale($appHeaders['lang']) ;


        return $next($request);
    }
}
