<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Logs;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ControllerBase extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($company, $attributes = ['where'=>['eliminar = 0']])
	{
		# ¿Usuario tiene permiso para ver?
		// $this->authorize('view', $this->entity);

		# Log
		$this->log('index');

		$query = $this->entity->with($this->entity->getEagerLoaders())->orderby($this->entity->getKeyName(),'DESC');

		if(isset($attributes['where'])) {
			foreach ($attributes['where'] as $key=>$condition) {
				$query->where(DB::raw($condition));
			}
		}

		if(isset($attributes['whereHas'])) {
			foreach ($attributes['whereHas'] as $relation => $callback) {
				$query->whereHas($relation, $callback);
			}
		}

		$dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

		if (!request()->ajax()) {
			return view(currentRouteName('smart'), $dataview+[
				'fields' => $this->entity->getFields(),
				'data' => $query->limit(20)->get(),
			]);

		# Ajax
		} else {
			$appendable = $this->entity->getAppendableFields();

			# Retorna resultados, los cache antes si no existen
			$cache = Cache::tags(getCacheTag())->rememberForever(getCacheKey(), function() use ($query, $appendable) {

				$all = $query->get();

				$page = request()->page ?: 1;
				$perPage = 4000;

				$items = $all->forPage($page, $perPage)->each(function($item) use ($appendable) {
					$item->setAppends($appendable);
				});

				# Eliminamos primeros 20 registros en pagina #1
				if( $page == 1) $items = $items->slice(20);

				return (new LengthAwarePaginator($items, $all->count(), $perPage, $page))->toJson();
			});
			return response()->json()->setJson($cache);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($company, $attributes =[])
	{
		# ¿Usuario tiene permiso para crear?
		// $this->authorize('create', $this->entity);

		$data = $this->entity->getColumnsDefaultsValues();

		$dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

		return view(currentRouteName('smart'), $dataview+['data'=>$data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $company)
	{
		# ¿Usuario tiene permiso para crear?
		// $this->authorize('create', $this->entity);

		# Validamos request, si falla regresamos pagina
		$this->validate($request, $this->entity->rules);

		$isSuccess = $this->entity->create($request->all());
		if ($isSuccess) {

			# Eliminamos cache
			Cache::tags(getCacheTag('index'))->flush();

			$this->log('store', $isSuccess->id_banco);
			return $this->redirect('store');
		} else {
			$this->log('error_store');
			return $this->redirect('error_store');
		}
	}

	/**
	 * Display the specified resource
	 *
	 * @param  integer $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($company, $id, $attributes =[])
	{
		# ¿Usuario tiene permiso para ver?
		// $this->authorize('view', $this->entity);

		# Log
		$this->log('show', $id);
		$data = $this->entity->findOrFail($id);
		$dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

		return view(currentRouteName('smart'), $dataview+['data'=>$data]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  integer $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($company, $id, $attributes =[])
	{
		# ¿Usuario tiene permiso para actualizar?
		// $this->authorize('update', $this->entity);

		$data = $this->entity->findOrFail($id);
		$dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

		return view(currentRouteName('smart'), $dataview+['data'=>$data]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  integer  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $company, $id)
	{
		# ¿Usuario tiene permiso para actualizar?
		// $this->authorize('update', $this->entity);

		# Validamos request, si falla regresamos atras
		$this->validate($request, $this->entity->rules);

		$entity = $this->entity->findOrFail($id);
		$entity->fill($request->all());
		if ($entity->save()) {

			# Eliminamos cache
			Cache::tags(getCacheTag('index'))->flush();

			$this->log('update', $id);
			return $this->redirect('update');
		} else {
			$this->log('error_update', $id);
			return $this->redirect('error_update');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  integer  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $company, $idOrIds)
	{
		# ¿Usuario tiene permiso para eliminar?
		// $this->authorize('delete', $this->entity);

		# Unico
		if (!is_array($idOrIds)) {

			$isSuccess = $this->entity->where($this->entity->getKeyName(), $idOrIds)->update(['eliminar' => 't']);
			if ($isSuccess) {

				$this->log('destroy', $idOrIds);

				# Eliminamos cache
				Cache::tags(getCacheTag('index'))->flush();

				if ($request->ajax()) {
					# Respuesta Json
					return response()->json([
						'success' => true,
					]);
				} else {
					return $this->redirect('destroy');
				}

			} else {

				$this->log('error_destroy', $idOrIds);

				if ($request->ajax()) {
					# Respuesta Json
					return response()->json([
						'success' => false,
					]);
				} else {
					return $this->redirect('error_destroy');
				}
			}

		# Multiple
		} else {

			$isSuccess = $this->entity->whereIn($this->entity->getKeyName(), $idOrIds)->update(['eliminar' => 't']);
			if ($isSuccess) {

				# Shorthand
				foreach ($idOrIds as $id) $this->log('destroy', $id);

				# Eliminamos cache
				Cache::tags(getCacheTag('index'))->flush();

				if ($request->ajax()) {
					# Respuesta Json
					return response()->json([
						'success' => true,
					]);
				} else {
					return $this->redirect('destroy');
				}

			} else {

				# Shorthand
				foreach ($idOrIds as $id) $this->log('error_destroy', $id);

				if ($request->ajax()) {
					# Respuesta Json
					return response()->json([
						'success' => false,
					]);
				} else {
					return $this->redirect('error_destroy');
				}
			}
		}
	}

	/**
	 * Remove multiple resources from storage.
	 * @param  Request $request
	 * @param  string  $company
	 * @return \Illuminate\Http\Response
	 */
	public function destroyMultiple(Request $request, $company)
	{
		# ¿Usuario tiene permiso para eliminar?
		// $this->authorize('delete', $this->entity);

		# Shorthand
		if ($request->ids) return $this->destroy($request, $company, $request->ids);

		return response()->json([
			'success' => false,
		]);
	}

	/**
	 * Obtenemos reporte
	 * @param  string $company
	 * @return file
	 */
	public function export(Request $request, $company)
	{
		# ¿Usuario tiene permiso para exportar?
		// $this->authorize('export', $this->entity);

		$type = strtolower($request->type);
		// $style = isset($request->style) ? $request->style : false;

	 //    if (isset($request->ids)) {
	 //        $ids = is_array($request->ids) ? $request->ids : explode(',',$request->ids);
	 //        $data = $this->entity->whereIn($this->entity->getKeyName(), $ids)->get();
		// }
		// else {
		//     $data = $this->entity->get();
		// }

		// $fields = $this->entity->getFields();

		// $alldata = $data;

		// try {

		// $alldata = $data->map(function ($data) use ($fields) {
		//     $return = [];

		//     foreach ($fields as $field=>$lable) {
		//         $return[$lable] = html_entity_decode(strip_tags($data->$field));
		//     }
		//     // dump( $return );
		//     return $return;
		// });

		// } catch (Exception $e) {

		// 	dump( $e );

		// }

		// echo "string";

		$data = '';
		$alldata = '';
		$style = $this->entity;

		if($type == 'pdf') {
		    $pdf = PDF::loadView(currentRouteName('smart'), ['fields' => $fields, 'data' => $data]);
		    return $pdf->stream(currentEntityBaseName().'.pdf')->header('Content-Type',"application/$type");
		}
		else {
		    Excel::create(currentEntityBaseName(), function($excel) use($data,$alldata,$type,$style) {
		        $excel->sheet(currentEntityBaseName(), function($sheet) use($data,$alldata,$type,$style) {
    		        // if ($style) {
    		        //     $sheet->loadView(currentRouteName('smart'), ['fields' => $this->entity->getFields(), 'data' => $data]);
    		        // } else {
		// echo "dos";
		// dump( $alldata );


						$style->chunk(500, function ($rows) use ($sheet) {
							// dump($rows);
							$sheet->rows($rows->toArray());


			                // foreach ($rows as $row)
			                // {
			                //     $sheet->appendRow($row);
			                // }

						});

    		            // $sheet->fromArray($alldata);
    		        // }
    	        });
		    })->download($type);
		}
	}

	/**
	 * Insertamos log
	 * @param  string $type
	 * @param  integer $id
	 * @return void
	 */
	public function log($type, $id = null)
	{
		switch ($type) {
			case 'index':
				Logs::createLog($this->entity->getTable(), request()->company, null, 'index', null);
				break;

			case 'show':
				Logs::createLog($this->entity->getTable(), request()->company, $id, 'ver', null);
				break;

			case 'store':
				Logs::createLog($this->entity->getTable(), request()->company, $id, 'crear', 'Registro insertado');
				break;

			case 'error_store':
				Logs::createLog($this->entity->getTable(), request()->company, null, 'crear', 'Error al insertar');
				break;

			case 'update':
				Logs::createLog($this->entity->getTable(), request()->company, $id, 'editar', 'Registro actualizado');
				break;

			case 'error_update':
				Logs::createLog($this->entity->getTable(), request()->company, $id, 'editar', 'Error al editar');
				break;

			case 'destroy':
				Logs::createLog($this->entity->getTable(), request()->company, $id, 'eliminar', 'Registro eliminado');
				break;

			case 'error_destroy':
				Logs::createLog($this->entity->getTable(), request()->company, $id, 'eliminar', 'Error al eliminar');
				break;

			default:
				break;
		}
	}

	public function redirect($type)
	{
		switch ($type) {
			case 'store':
				$message = ['type'=> 'toast_success', 'text' => 'Registro creado correctamente.'];
				break;

			case 'error_store':
				$message = ['type'=> 'toast_error', 'text' => 'No fue posible crear registro.'];
				break;

			case 'update':
				$message = ['type'=> 'toast_success', 'text' => 'Registro actualizado correctamente.'];
				break;

			case 'error_update':
				$message = ['type'=> 'toast_error', 'text' => 'No fue posible actualizar registro.'];
				break;

			case 'destroy':
				$message = ['type'=> 'toast_success', 'text' => 'Registro (s) eliminado correctamente.'];
				break;

			case 'error_destroy':
				$message = ['type'=> 'toast_error', 'text' => 'No fue posible eliminar registro (s).'];
				break;

			default:
				break;
		}

		return redirect(companyRoute('index'))->with('message', $message);
	}
}