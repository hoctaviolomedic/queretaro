<?php

namespace App\Http\Models\Captura;

use Illuminate\Database\Eloquent\Model;

class TiposDeProductos extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'cat_tipo_producto';

	/**
	 * The primary key of the table
	 * @var string
	 */
	protected $primaryKey = 'id_tipo';

}
