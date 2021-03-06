<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth.session');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	    if(empty(request()->company))
	        return redirect()->route('login');

		return view('home');
	}
}