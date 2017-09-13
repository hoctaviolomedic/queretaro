<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Http\Models\Captura\Localidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntradasController extends Controller
{
	public function pedidos() {

		$localidades = DB::select('SELECT l.id_localidad AS key, l.localidad AS localidad FROM cat_localidad l, adm_usuario_localidad ul
			WHERE l.id_localidad = ul.id_localidad AND ul.id_usuario = :id_usuario AND l.estatus=1
			AND EXISTS (SELECT i.* FROM inv_inventario i, inv_almacen a WHERE i.id_almacen=a.id_almacen AND a.id_localidad=l.id_localidad AND i.estatus=1) ORDER BY localidad', ['id_usuario'=> Auth::id()]);

		// dump( $localidades );
		// dump( Auth::id() );

		return view(currentRouteName(), [
			'localidades' => $localidades
		]);
	}

	public function endpoint() {

		$response = ['success' => 0, 'data' => []];

		switch (request()->action) {
			case 'change-localidad':

				$response['data'] = DB::select('SELECT pe.id_pedido as id_pedido, pe.id_pedido as pedido FROM inv_pedido_entrada AS pe
					INNER JOIN inv_salida AS s ON s.id_pedido=pe.id_pedido INNER JOIN inv_pedido AS p ON p.id_pedido=pe.id_pedido
					WHERE pe.estatus IN (0,1) AND pe.estatus_en_uso=0 AND (s.cantidad-s.cantidad_entrada)>0 AND p.id_localidad=:id_localidad
					GROUP BY pe.id_pedido ORDER BY id_pedido', ['id_localidad'=> request()->id]);

				if ($response['data']) $response['success'] = 1;

				return response()->json()->setJson(json_encode($response));
				break;

			case 'change-pedido':

				$response['data'] = DB::select('SELECT pe.folio_resurtido AS label, pe.fecha_captura AS value, (CASE WHEN estatus_en_uso=1 THEN 0 ELSE 1 END) AS estatus
					FROM inv_pedido_entrada pe WHERE pe.id_pedido = :id_pedido AND pe.estatus IN (0,1)
					ORDER BY cast(pe.folio_resurtido as int)', ['id_pedido'=> request()->id]);

				if ($response['data']) $response['success'] = 1;

				return response()->json()->setJson(json_encode($response));
				break;

			case 'listar-pedido':

				$response['data']['resurtidos'] = DB::table('inv_pedido_entrada AS pe')
					->join('inv_salida AS s', function($join) {
						$join->on('s.id_pedido','=','pe.id_pedido')->on('s.fecha_captura','=','pe.fecha_captura');
					})
					->join('inv_existencia AS ext', function($join) {
						$join->on('ext.codigo_barras','=','s.codigo_barras')->on('ext.no_lote','=','s.no_lote')->on('ext.id_ubicacion','=','s.id_ubicacion');
					})
					->join('cat_producto_codigo_barras as pcb', 'pcb.codigo_barras', '=', 's.codigo_barras')
					->join('catalogo_producto as cp', 'cp.clave', '=', 'pcb.clave')
					->where('s.id_pedido','=', request()->id_pedido )
					->whereIn('s.fecha_captura', request()->resurtidos )
					->whereRaw('(s.cantidad-s.cantidad_entrada)>0')
					->select('s.*', DB::raw('(cp.descripcion || cp.presentacion) AS name'), 'ext.caducidad', 'pe.folio_resurtido', 'pcb.holograma')
					->orderBY('pe.folio_resurtido', 's.codigo_barras', 'ext.caducidad')
					->get();

				$response['data']['almacenes'] = DB::select("SELECT a.id_almacen AS id_almacen, a.almacen AS almacen FROM inv_almacen a
					WHERE a.id_localidad = :id_localidad AND a.estatus=1 AND a.id_tipo_almacen IN (1,3,8,9)
					AND EXISTS(SELECT * FROM inv_inventario i1 WHERE i1.id_almacen = a.id_almacen AND i1.estatus = '1' LIMIT 1)
					AND NOT EXISTS(SELECT * FROM inv_inventario i2 WHERE i2.id_almacen = a.id_almacen AND i2.estatus = '0' LIMIT 1)", ['id_localidad' => request()->id_localidad]);

				if ($response['data']['resurtidos'] && $response['data']['almacenes']) $response['success'] = 1;

				return response()->json()->setJson(json_encode($response));
				break;

			case 'change-almacen':

				$codigo_barras = request()->codigo_barras;
				$typo_codigo_barras = DB::select("SELECT array_to_string(array_agg(id_tipo), ',') AS id_tipo FROM cat_producto_tipo WHERE codigo_barras = '$codigo_barras'");

				$almacen = request()->id;
				$typo_almacen = DB::select("SELECT id_tipo_almacen FROM inv_almacen WHERE id_almacen = '$almacen'");

				if( in_array('5', explode(",", $typo_codigo_barras[0]->id_tipo), false) && $typo_almacen[0]->id_tipo_almacen !=3  && $typo_almacen[0]->id_tipo_almacen!=2 && $typo_almacen[0]->id_tipo_almacen!=7 && $typo_almacen[0]->id_tipo_almacen!=8){
					$response['data']['almacen_controlado'] = true;
				}

				if( !in_array('5', explode(",", $typo_codigo_barras[0]->id_tipo), false) && $typo_almacen[0]->id_tipo_almacen==8){
					$response['data']['almacen_controlado'] = false;
				}

				$response['data']['almacenes'] = DB::select("SELECT u.nomenclatura AS label, u.id_ubicacion AS value FROM inv_ubicacion u WHERE u.id_almacen=$almacen AND u.estatus=1 ORDER BY label");

				if ($response['data']['almacenes']) $response['success'] = 1;

				return response()->json()->setJson(json_encode($response));
				break;

			case 'insertar-entrada':

				// dump( request()->all() );

				$pedido = request()->id_pedido;
				$localidad = request()->id_localidad;
				$folio = DB::select("SELECT max(cast(substr(folio_entrada,3) AS integer))+1 as folio FROM inv_entrada WHERE id_localidad = $localidad AND folio_entrada like 'P%'");
				$folio = $folio[0]->folio != '' ? "p-{$folio[0]->folio}" : 'P-1';

				//
				$entradas = [];

				foreach (request()->entradas as $key => $entrada) {

					$localidad = $entrada['id_localidad'];

					// dump( $entrada );

					#Verificar si existe la relacion CB, LOTE y UBI en la tabla de inv_existencia si no existe Insertar y se existe incrementar Existencias

					$result = DB::select("SELECT * FROM inv_existencia WHERE codigo_barras='{$entrada['codigo_barras']}' AND no_lote='{$entrada['no_lote']}' AND id_ubicacion={$entrada['id_ubicacion']}");
					if ($result) {
						$result = DB::update("UPDATE inv_existencia SET quedan=quedan+{$entrada['cantidad_entrada']} WHERE codigo_barras='{$entrada['codigo_barras']}' AND no_lote='{$entrada['no_lote']}' AND id_ubicacion={$entrada['id_ubicacion']}");
					} else {
						$result = DB::insert("INSERT INTO inv_existencia(codigo_barras, no_lote, id_ubicacion, quedan, caducidad, costo, id_almacen, id_localidad)
							VALUES ('{$entrada['codigo_barras']}', '{$entrada['no_lote']}', {$entrada['id_ubicacion']}, {$entrada['cantidad_entrada']}, '{$entrada['caducidad']}', 0, {$entrada['id_almacen']}, $id_localidad);");
					}

					#Se inserta el Nuevo movimiento en la tabla de inv_entrada, obtener el folio de resurtido de inv_pedido_entrada para insertarlo como documento

					$result = DB::select("SELECT e.folio_resurtido FROM inv_salida AS s
						INNER JOIN inv_pedido_entrada AS e ON e.id_pedido=s.id_pedido AND e.fecha_captura = s.fecha_captura WHERE id_salida={$entrada['id_salida']}");

					$fecha=date('Y-m-d H:i:s');
					$observaciones = '';

					$dataset = [
						'fecha_captura' => $fecha,
						'cantidad' => $entrada['cantidad_entrada'],
						'no_documento' => "{$entrada['id_pedido']} - {$result[0]->folio_resurtido}",
						'id_proveedor' => null,
						'costo' => 0,
						'observaciones' => strtoupper($observaciones),
						'id_usuario_captura' => Auth::Id(),
						'id_pedido' => $entrada['id_pedido'],
						'id_localidad' => $entrada['id_localidad'],
						'folio_entrada' => $folio,
						'id_salida' => $entrada['id_salida'],
						'codigo_barras' => $entrada['codigo_barras'],
						'no_lote' => $entrada['no_lote'],
						'id_ubicacion' => $entrada['id_ubicacion']
					];

					$id_movimiento = DB::table('inv_entrada')->insertGetId($dataset, 'id_movimiento');

					#
					$entradas[] = $id_movimiento;

					# Incrementar en la salida la cantidad entrada e insertar la salidad en el historial
					$result = DB::update("UPDATE inv_salida SET cantidad_entrada=cantidad_entrada+{$entrada['cantidad_entrada']} WHERE id_salida={$entrada['id_salida']}");

				}

				$response['data'] = "/almacen/entradas/pedido/pdf_entrada_pedido.php?localidad={$localidad}&folio={$folio}&pedido={$pedido}";
				$response['success'] = 1;

				return response()->json()->setJson(json_encode($response));
				break;


			default:
				break;
		}



	}

}