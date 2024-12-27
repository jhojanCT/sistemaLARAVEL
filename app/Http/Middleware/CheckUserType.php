<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importación de Auth


class CheckUserType
{
    
    public function handle(Request $request, Closure $next, $type): Response
    {
        if (Auth::guard('users')->check() && Auth::guard('users')->user()->user_tipo != $type) {
            return redirect('/login');
        }

        return $next($request);
    }
}
