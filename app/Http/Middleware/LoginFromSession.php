<?php

namespace App\Http\Middleware;

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
        session_name('abisa');
        session_start();

        if(isset($_SESSION['idUser']) &&  isset($_SESSION['passwd'])){

            Auth::loginUsingId($_SESSION['idUser']);
            return $next($request);

        } else {
            return redirect("../");
        }

        return $next($request);
    }
}
