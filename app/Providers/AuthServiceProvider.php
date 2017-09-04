<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		// "App\Model" => "App\Policies\ModelPolicy"
		// "App\Http\Models\Administracion\Bancos" => "App\Policies\Administracion\BancosPolicy"
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		# Agregamos politicas dinamicamente
		foreach (glob('../app/Policies/*/*Policy.php') as $politica) {
			$policy = 'App' . str_replace('/', '\\', substr($politica, 6, -4));
			$model = substr(str_replace('Policies', 'Http\Models', $policy), 0, -6);
			$this->policies[$model] = $policy;
		}

		$this->registerPolicies();
	}
}
