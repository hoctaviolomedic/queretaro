<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		# Extend Route Resource
		$registrar = new \App\Http\ResourceRegistrar($this->app['router']);
		$this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
			return $registrar;
		});

		//
		\Route::resourceVerbs([
			'create' => 'crear',
			'edit' => 'editar',
//            'impress'=>'imprimir',
		]);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		require_once __DIR__ . '/../helpers.php';
	}
}
