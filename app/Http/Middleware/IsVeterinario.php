<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVeterinario
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'veterinario') {
            return $next($request);
        }
        abort(403, 'No tienes permiso para acceder como veterinario.');
    }
}
