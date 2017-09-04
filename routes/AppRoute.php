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

Auth::routes();

$Conecctions = implode('|',array_keys(config('database.connections')));

Route::get('/', 'HomeController@index')->name('home');

Route::pattern('company', "($Conecctions)");

Route::prefix('{company}')->group(function () {
    Route::resource('/', 'HomeController',['middleware' => 'share']);
});
