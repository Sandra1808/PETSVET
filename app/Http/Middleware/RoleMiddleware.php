<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (!$request->user()) {
        return redirect('/login'); // Redirigir si el usuario no ha iniciado sesión
    }

    if (!in_array($request->user()->role, $roles)) {
        abort(403); // Denegar acceso si el usuario no tiene el rol correcto
    }

    return $next($request);
}

}
