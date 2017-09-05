<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$Conecctions = implode('|',array_keys(config('database.connections')));

Route::pattern('company', "($Conecctions)");

Route::prefix('{company}')->group(function () {

	Route::group(['prefix' => 'captura', 'as' => 'captura.', 'middleware' => ['share'] ], function() {
		Route::post('getAfiliados','captura\RecetasController@getAfiliados')->name('recetas.getAfiliados');
		Route::post('getDiagnosticos','captura\RecetasController@getDiagnosticos')->name('recetas.getDiagnosticos');
		Route::post('getMedicamentos','captura\RecetasController@getMedicamentos')->name('recetas.getMedicamentos');
	    Route::resource('recetas', 'captura\RecetasController');
		Route::resource('requesiciones', 'captura\RequisicionesController');
	});
});
