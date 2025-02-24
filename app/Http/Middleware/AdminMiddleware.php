<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Usuário autenticado e é admin?
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Resposta para APIs
        if ($request->wantsJson()) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        if(auth()->user()){
            \Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        // Redireciona para login com erro 403 (Forbidden)
        return redirect()
            ->route('login')
            ->with('error', 'Acesso não autorizado!')
            ->setStatusCode(403);
    }
}
