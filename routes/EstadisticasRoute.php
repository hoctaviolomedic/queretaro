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

	Route::group(['prefix' => 'estadisticas', 'as' => 'estadisticas.', 'middleware' => ['share', 'auth.session'] ], function() {
        Route::post('pgetLocalidades','Estadisticas\PedidosController@getLocalidades')->name('pedidos.getlocalidades');
        Route::post('rgetLocalidades','Estadisticas\RequisicionesController@getLocalidades')->name('requisiciones.getlocalidades');
        Route::post('egetLocalidades','Estadisticas\RecetasController@getLocalidades')->name('recetas.getlocalidades');
        
        Route::resource('generales', 'Estadisticas\GeneralesController');
        Route::resource('gastos', 'Estadisticas\GastosController');
        Route::resource('pedidos', 'Estadisticas\PedidosController');
        Route::resource('requisiciones', 'Estadisticas\RequisicionesController');
        Route::resource('recetas', 'Estadisticas\RecetasController');
    });
});
