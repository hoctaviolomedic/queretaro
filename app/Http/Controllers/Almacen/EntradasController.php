<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EntradasController extends Controller
{
	public function pedidos() {

		dump( Auth::user() );

		return view(currentRouteName());
	}
}