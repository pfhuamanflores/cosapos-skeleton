<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministradorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->tieneRol(Rol::ADMIN_SISTEMA), 403);

        return $next($request);
    }
}
