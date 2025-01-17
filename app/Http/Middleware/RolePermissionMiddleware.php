<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolePermissionMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Verifica si el usuario está autenticado
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        // Superadmin tiene acceso total
        if ($user->hasRole('superadmin')) {
            return $next($request);
        }

        // Obtén el nombre de la ruta actual
        $routeName = $request->route()->getName();

        // Mapea el nombre de la ruta al permiso requerido
        $permission = $this->getPermissionFromRoute($routeName);

        // Verifica si el usuario tiene el permiso requerido
        if ($permission && !$user->can($permission)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }

    
}
