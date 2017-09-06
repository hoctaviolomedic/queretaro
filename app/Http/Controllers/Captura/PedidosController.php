<?php

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Pedidos;
use Illuminate\Support\Facades\DB;

class PedidosController extends ControllerBase
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Pedidos $entity)
	{
		$this->entity = $entity;
	}



	public function getDataView()
	{
		return [
			// 'companies' => Empresas::active()->select(['nombre_comercial','id_empresa'])->pluck('nombre_comercial','id_empresa'),
			// 'users' => Usuarios::active()->select(['nombre_corto','id_usuario'])->pluck('nombre_corto','id_usuario')
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($company, $attributes = [])
	{

		$id_cliente = 135; # 135: Queretaro

		// DB::enableQueryLog();

		// $localidades = Pedidos::whereHas('localidad', function($query) use ($id_cliente) {
		// 	$query->where('id_cliente', 135);
		// })->get();

		// dump( $localidades );


		// dump( DB::getQueryLog() );

		return parent::index($company, ['whereHas' =>
			['localidad' => function($query) use ($id_cliente) {
				$query->where('id_cliente', 135);
			}]
		]);

		// $localidades->each(function($item, $key){

		//     dump( $item->localidad );

		// });

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($company, $attributes = [])
	{
		return parent::create($company, [
			'dataview' => $this->getDataView()
		]);
	}

	/**
	 * Display the specified resource
	 *
	 * @param  integer $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($company, $id, $attributes = [])
	{
		return parent::show($company, $id, [
			'dataview' => $this->getDataView()
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  integer $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($company, $id, $attributes = [])
	{
		return parent::edit($company, $id, [
			'dataview' => $this->getDataView()
		]);
	}
}