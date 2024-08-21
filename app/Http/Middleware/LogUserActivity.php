<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Obtener información del usuario y la petición
        $user = auth()->user();
        list($controller, $accion) = explode('@', $request->route()->getActionName());
        $controller = class_basename($controller);

        // Loguear la acción
        Log::channel('user_activity')->info("$controller.$accion", [
            'user' => $user->rpe,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
        ]);

        return $next($request);
    }
}
