<?php

namespace App\Http\Models\Captura;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'inv_pedido_detalle';

	/**
	 * The primary key of the table
	 * @var string
	 */
	protected $primaryKey = null;

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * Obtenemos cuadro relacionado
	 * @return relation
	 */
	public function cuadro_producto() {
		return $this->hasOne(CuadroProductos::class, 'clave_cliente', 'clave_cliente')->where('id_cuadro','=', $this->id_cuadro)->where('clave_cbn','!=', '')->whereNotNull('clave_cbn')->with('unidad_medida');
	}

}
