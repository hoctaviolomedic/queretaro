<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelBase;

class Pedidos extends ModelBase
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'inv_pedido';

	/**
	 * The primary key of the table
	 * @var string
	 */
	protected $primaryKey = 'id_pedido';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The validation rules
	 * @var array
	 */
	public $rules = [];

	/**
	 * Los atributos que seran visibles en index-datable
	 * @var array
	 */
	protected $fields = [
		'id_pedido' => '#',
		'localidad.localidad' => 'Localidad',
		'tipodeproducto.descripcion' => 'Tipo de Producto',
		'estatus_text' => 'Estatus',
	];

	/**
	 * Atributos de carga optimizada
	 * @var array
	 */
	protected $eagerLoaders = ['localidad', 'tipodeproducto'];

	/**
	 * Accessor
	 * @return string
	 */
	public function getEstatusTextAttribute() {
		switch ($this->estatus) {
			case '0':
				$estatus = 'Nuevo';
				break;

			case '1':
				$estatus = 'Parcialmente Surtido';
				break;

			case '2':
				$estatus = 'Completo';
				break;

			case '3':
				$estatus = 'Cerrado';
				break;

			case '4':
				$estatus = 'Cancelado';
				break;

			default:
				$estatus = '';
				break;
		}
		return $estatus;
	}

	/**
	 * Obtenemos localidad relacionada
	 * @return Empresa
	 */
	public function localidad()
	{
		return $this->belongsTo(Localidades::class, 'id_localidad', 'id_localidad');
	}

	/**
	 * Obtenemos localidad relacionada
	 * @return Empresa
	 */
	public function tipodeproducto()
	{
		return $this->belongsTo(TiposDeProductos::class, 'id_tipo_producto', 'id_tipo');
	}

}
