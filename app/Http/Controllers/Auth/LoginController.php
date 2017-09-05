<?php
namespace App\Http\Controllers\Auth;

use Session;
use Auth;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Models\Administracion\Usuarios;
use App\Http\Models\Administracion\Empresas;

class LoginController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Login Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles authenticating users for the application and
     | redirecting them to your home screen. The controller uses a trait
     | to conveniently provide its functionality to your applications.
     |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest',['except'=>'logout']);
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->usuario, FILTER_VALIDATE_EMAIL) ? $this->username() : 'usuario';
        return [$field => $request->{$field}, 'password' => $request->password, 'activo' => 1,'eliminar'=> 0];
    }

    protected function validateLogin(Request $request)
    {
        $field = filter_var($request->usuario, FILTER_VALIDATE_EMAIL) ? $this->username() : 'usuario';
        $this->validate($request, [$field => 'required', 'password' => 'required',]);
    }

    /**
     * Redirige a usuario una nez iniciada la session
     * @param  Request $request
     * @param  Usuarios $usuario
     * @return rediredt
     */
    protected function authenticated(Request $request, $usuario)
    {
        // $empresa = Empresas::findOrFail($usuario->fk_id_empresa_default);
        // return redirect("/$empresa->conexion");
        return redirect('/abisa');
    }

}