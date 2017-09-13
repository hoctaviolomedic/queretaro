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

    Route::group(['prefix' => 'almacen', 'as' => 'almacen.'], function() {
        Route::group(['prefix' => 'entradas', 'as' => 'entradas.', 'middleware' => ['share', 'auth.session'] ], function() {
            Route::get('pedidos','Almacen\EntradasController@pedidos')->name('pedidos');
            Route::post('pedidos-endpoint','Almacen\EntradasController@endpoint')->name('pedidos-endpoint');
        });
    });
});
