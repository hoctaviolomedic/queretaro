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
	 * Opciones para exportar
	 * @var array
	 */
	protected $smart_exports = [
		'ORACLE' => 'Archivo ORACLE',
	];

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

	public function oracleCollections($collections) {

		$return = [];

		$po_headers = [
			'COMMENTS' => 'PO prueba$ Abisalud', # Descipción: PO ___CARGA INICIAL (El número debe corresponder a la orden de compra de su sistema actual)
			'DOC_TYPE_NAME' => 'Orden de Compra Standard', # Siempre va a ser -Orden de Compra Standard-
			'VENDOR_NAME' => 'ABASTECEDORA DE INSUMOS PARA LA SALUD S.A. DE C.V.', # Proveedor: Siempre va a ser -ABASTECEDORA DE INSUMOS PARA LA SALUD S.A. DE C.V.-
			'VENDOR_SITE_CODE' => 'SESEQ', # Sucursal/Site: Siempre va a ser SESEQ
			'VENDOR_CONTACT' => '*', # Contacto: Nombre del contacto de proveedor sólo si se dio de Alta. De Lo contrario Ingresar (*) asterisco
			'SHIP_TO_LOCATION' => '', # Envío: Dirección de envío de la organización. (Revisar LOV1)
			'BILL_TO_LOCATION' => 'SESEQ_OFC', # Facturación: Siempre va a ser -SESEQ_OFC-
			'CURRENCY_CODE' => 'MXN', # Divisa: Moneda en la que se realiza la compra. Dejar MXN para todas las líneas
			'RATE_TYPE' => '*', # Clase TC: Dejar asterisco (*)
			'RATE_DATE' => '*', # Fecha TC: Dejar asterisco (*)
			'RATE' => '*', # Tipo Cambio: Dejar asterisco (*)
			'AGENT_NAME' => 'SANCHEZ RANGEL? MA DE LOS ANGELES', # Comprador: Nombre del comprador, debe de estar dado de alta como empleado, comprador y existir en jeraquía de Aprobación. Siempre va a ser el usuario de compras designado.
			'STATUS' => 'Incompleto', # Estado: Para todas las ordenes de compra será Incompleto
			'ATTRIBUTE1' => '*', # Cuadro Compatarativo: Valor opcional. Sino usan éste, usar asterisco (*) para todas las líneas de la PO
			'ATTRIBUTE2' => '*', # Retención: Valor opcional. Sino usan éste, usar asterisco (*) para todas las líneas de la PO
			'ATTRIBUTE3' => '*', # Consecutivo Dependencia: Valor opcional. Sino usan éste, usar asterisco (*) para todas las líneas de la PO
			'ATTRIBUTE4' => '*', # Num. de Contrato o Licitación: Valor opcional. Solo aplica para SESEQ y No es requerido. Sino usan éste, usar asterisco (*) para todas las líneas de la PO
			'ATTRIBUTE5' => '*', # Informe OIC: Valor opcional. Sino usan éste, usar asterisco (*) para todas las líneas de la PO
			'ATTRIBUTE6' => 'PO prueba$ Abisalud', # Usar el mismo valor que en la primera columna
		];

		foreach ($collections->cursor() as $item) {
			foreach ($item->detalle as $key => $detalle) {

				// dump( $item );

				$po_lines = [
					'LINE_NUM' => ($key+1), # Número de Línea: Número de línea de la Orden de compra.
					'LINE_TYPE' => 'Mercaderías', # Tipo: Siempre va a ser -Mercaderías-
					'ITEM_NUMBER' => $detalle->cuadro_producto->clave_cliente, # Artículo: Código del Artículo dado de alta en Inventarios y asignado a la organizacion dónde se realiza la Orden de compra. (Revisar LOV2)
					'ITEM_CATEGORY' => 'MAT Y SUMINISTROS.PROD QUIM FARMACEUTICOS Y DE LABORATORIO.MEDICINAS Y PROD FARMACEUTICOS', # Categoría: Categoría asignada al artículo, validar en el módulo de inventarios. (Dependiente LOV2)
					'UNIT_MEAS_LOOKUP_CODE_T' => $detalle->cuadro_producto->unidad_medida ? $detalle->cuadro_producto->unidad_medida->descripcion : 'ENVASE', # UDM: Unidad de medida asignada al artículo en el módulo de inventarios. (Dependiente LOV2)
					'QUANTITY' => $detalle->cantidad_pedida, # Cantidad: Cantidad REMANENTE de la orden de compra en el sistema anterior SIN FRACCIONAR. (No usar decimales)
					'UNIT_PRICE' => $this->fixTwoDecimals($detalle->cuadro_producto->precio), # Precio:  Precio del articulo que se tiene en el sistema anterior. Según catálogo precio pactado. (No usar comas ni más de dos decimales, ej: 17,25 -> 17.25)
					'PROMISED_DATE' => $this->formatDate($item->fecha_captura), # Pactado: Feha para cuando se requiere el bien. Si no se tiene el valor deben ingresar la fecha estimada de recepción de la compra.
					'NEED_BY' => $this->formatDate($item->fecha_captura), # Necesario Para: Fecha necesidad. Sino se tiene el valor piden dejar la fecha estimada de recepción de la compra
					'HAZARD_CLASS' => '*', # Peligro: Ingresar  asterisco (*)
					'TAX_NAME ' => 'IVA AP 0%', # Impuesto: Campturar el código de impuesto asignado al artículo, en la pestaña de Compra, campo Código de clasificación de impuesto; en el módulo de inventarios. (Dependiente LOV2)
				];

				$po_line_locations = [
					'SHIPMENT_NUM' => ($key+1), # Nro: Es el número de la línea de la orden de compra
					'SHIP_TO_ORGANIZATION_CODE' => $item->localidad->jurisdiccion->jurisdiccion, # Org: Código de la organización dónde será recibida la mercancía
					'SHIP_TO_LOCATION_CODE' => $item->localidad->localidad, # Envío: Dirección de la organización dónde se recibirá la mercancía
					'UNIT_MEAS_LOOKUP_CODE_TL' => $po_lines['UNIT_MEAS_LOOKUP_CODE_T'], # UDM: Unidad de medida asignada al artículo en el módulo de inventarios.
					'QUANTITY_AGAIN' => $po_lines['QUANTITY'], #  Cantidad: Cantidad REMANENTE de la orden de compra en el sistema anterior (SIN FRACCIONAR)
					'PROMISED_DATE_AGAIN' => $po_lines['PROMISED_DATE'], # Pactado: Feha para cuando se requiere el bien. Si no se tiene el valor deben ingresar la fecha estimada de recepción de la compra.
					'NEED_BY_AGAIN' => $po_lines['NEED_BY'], # Necesario Para: Fecha necesidad. Sino se tiene el valor piden dejar la fecha estimada de recepción de la compra
					'NOTE_TO_RECEIVER' => '*', # Nota Para el Receptor: Opcional, sino hay comentario dejar asterisco (*)
				];

				$po_line_distributions = [
					'DESTINATION_TYPE' => 'Gasto', # Tipo: SIEMPRE SERÁ -Gasto-
					'DELIVER_TO_PERSON' => $po_headers['AGENT_NAME'], # Solicitante: Nombre del solicitante, deberá ser empleado y estar dado de alta en el módulo de HR, previo a la carga de Órdenes de compra
					'DELIVER_TO_LOCATION' => $po_line_locations['SHIP_TO_LOCATION_CODE'], # Entrega: Domicilio de entrega, en caso de no tener el valor dejar asterisco (*)
					'QUANTITY_ORDERED' => $po_lines['QUANTITY'], # Cantidad: Cantidad REMANENTE de la orden de compra en el sistema anterior (FRACCIONADA)
					'CHARGE_ACCOUNT_FLEX' => '04.5253031.U301.33331E036531.232.63L.S.1.99998', # Cuenta Cargo OC: Ingresar la combinación contable presupuestal que será afectada presupuestalmente. Debe ser una cuenta válida.
					'GL_ENCUMBERED_DATE' => '31/07/2014', # Fecha Contable: Fecha del último día, del periódo de cierre anterior. Debera estar dentro de un periodo contable abierto.
				];

				$return[] = array_merge($po_headers, [
					'COMMENTS' => sprintf('PO prueba%d Abisalud', $item->id_pedido),
					'SHIP_TO_LOCATION' => 'SESEQ_' . $po_line_locations['SHIP_TO_ORGANIZATION_CODE'],
					'ATTRIBUTE6' => sprintf('PO prueba%d Abisalud', $item->id_pedido),
				], $po_lines, $po_line_locations, $po_line_distributions);
			}
		}
		return $return;
	}

	private function fixTwoDecimals($number) {
		return number_format($number, 2);
	}

	private function formatDate($datetime) {
		return date('d/m/Y', strtotime($datetime));
	}

	/**
	 * Obtenemos detalle relacionado
	 * @return relation
	 */
	public function detalle() {
		return $this->hasMany(PedidoDetalle::class, 'id_pedido')->with('cuadro_producto');
	}

	/**
	 * Obtenemos localidad relacionada
	 * @return relation
	 */
	public function localidad()
	{
		return $this->belongsTo(Localidades::class, 'id_localidad', 'id_localidad')->with('jurisdiccion');
	}

	/**
	 * Obtenemos tipo de producto relacionada
	 * @return relation
	 */
	public function tipodeproducto()
	{
		return $this->belongsTo(TiposDeProductos::class, 'id_tipo_producto', 'id_tipo');
	}

}
