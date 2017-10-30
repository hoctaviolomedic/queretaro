<?php

namespace App\Http\Models\Captura;

use Illuminate\Database\Eloquent\Model;

class CuadroProductos extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'cat_cuadro_producto';

	/**
	 * The primary key of the table
	 * @var string
	 */
	protected $primaryKey = 'id_cuadro';

	/**
	 * Obtenemos unidad de medida relacionada
	 * @return relation
	 */
	public function unidad_medida() {
		return $this->hasOne(UnidadMedida::class, 'id_unidad_medida', 'id_unidad_medida');
	}

	
	

}
