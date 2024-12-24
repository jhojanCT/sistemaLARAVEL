<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string|null 
     */
    //public function handle(Request $request, Closure $next): Response
    //{
    //    return $next($request);
    //}
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()){
            return route('login');
        }
    }

}
