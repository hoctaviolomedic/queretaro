<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Support\Facades\Auth;

use App\Http\Models\Administracion\Empresas;
use App\Http\Models\Administracion\Usuarios;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        # Si existe session, redirige a empresa default
        if (Auth::guard($guard)->check()) {
            // $usuario = Usuarios::where('id_usuario', Auth::Id())->first();
            // $empresa = Empresas::findOrFail($usuario->fk_id_empresa_default);
            // return redirect("/$empresa->conexion");
            return redirect('/abisa');
        }
        return $next($request);
    }
}
