<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Support\Facades\Auth;

class LoginFromSession
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
        # Si no existe session laravel pero si, session sistema anterior
        if (!Auth::guard($guard)->check() && Session::has('user_id')) {
            Auth::loginUsingId(Session::get('user_id'));
        } else {
            return redirect("/sistema-anterior");
        }

        return $next($request);
    }
}
