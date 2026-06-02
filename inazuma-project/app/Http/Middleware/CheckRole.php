<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        if (auth()->user()->rol !== $role) {
            return redirect()->route('jugadores.index')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
