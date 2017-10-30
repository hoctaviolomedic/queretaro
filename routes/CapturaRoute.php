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

	Route::group(['prefix' => 'captura', 'as' => 'captura.', 'middleware' => ['share','auth.session'] ], function() {
		Route::post('getAfiliados','Captura\RecetasController@getAfiliados')->name('recetas.getAfiliados');
        Route::post('getDiagnosticos','Captura\RecetasController@getDiagnosticos')->name('recetas.getDiagnosticos');
        Route::post('getMedicamentos','Captura\RecetasController@getMedicamentos')->name('recetas.getMedicamentos');
        Route::post('verifyStock','Captura\RecetasController@verifyStock')->name('recetas.verifyStock');
        Route::post('verifyStockSurtir','Captura\RecetasController@verifyStockSurtir')->name('recetas.verifyStockSurtir');
        Route::get('recetas/{id}/surtirReceta','Captura\RecetasController@surtirReceta')->name('recetas.surtirReceta');
        Route::post('recetas/{id}/surtir','Captura\RecetasController@surtir')->name('recetas.surtir');
        Route::get('recetas/{id}/imprimirReceta','Captura\RecetasController@imprimirReceta')->name('recetas.imprimirReceta');
        Route::resource('recetas', 'Captura\RecetasController');
        Route::resource('requisicioneshospitalarias', 'Captura\RequisicionesHospitalariasController');
        Route::post('getAreas','Captura\RequisicionesHospitalariasController@getAreas')->name('requisicioneshospitalarias.getAreas');
        Route::resource('pedidos', 'Captura\PedidosController');
        Route::get('surtidorecetas/{id}/imprimir','Captura\SurtidoRecetasController@imprimir')->name('surtidorecetas.imprimir');
        Route::get('surtidorecetas/getrecetas','Captura\SurtidoRecetasController@getrecetas')->name('surtidorecetas.getrecetas');
        Route::get('surtidorecetas/getrecetadetalle','Captura\SurtidoRecetasController@getrecetadetalle')->name('surtidorecetas.getrecetadetalle');
        Route::resource('surtidorecetas', 'Captura\SurtidoRecetasController');
    });
});
