<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdministrador
{
   public function handle($request, Closure $next)
{
    $user = auth()->user();

    // ✅ Verifica si es administrador por rol o tiene el permiso especial
    if ($user->role === 'administrador' || $user->hasPermission('administrador_total')) {
        return $next($request);
    }

    abort(403, 'No tienes permiso para acceder como administrador.');
}

}
