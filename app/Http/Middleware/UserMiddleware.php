<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // App\Http\Middleware\UserMiddleware.php
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->is_admin) {
            return $next($request);
        }

        if(auth()->user()){
            \Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect()->route('login')->with('error', 'Acesso não permitido para administradores!');
    }
}
