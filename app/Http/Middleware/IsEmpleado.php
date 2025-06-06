<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEmpleado
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'empleado') {
            return $next($request);
        }
        abort(403, 'No tienes permiso para acceder como empleado.');
    }
}
