<?php
namespace App\Http\Controllers\Estadisticas;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Localidades;
use Auth;
use DB;

class GastosController extends ControllerBase
{

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	
	public function index($company, $attributes = ['where'=>[]])
	{
	    return view('estadisticas.gastos.index',[
	        'localidades' => Localidades::where('id_cliente','=',135)->get()->pluck('localidad','id_localidad')->prepend('TODAS LAS LOCALIDADES','-999'),
	        'productos' => [],
	        'recetas' => [],
	        'medicos' => [],
	        'pacientes' => [],
	    ]);
	}
	
	public function store(Request $request, $company)
	{
	    #dd($request);
	    
	    $fecha_inicio = isset($request->datetimepicker1) ? $request->datetimepicker1 : '1900-01-01';
	    $fecha_fin = isset($request->datetimepicker2) ? $request->datetimepicker2 : '1900-01-01';
	    $localidad = isset($request->localidades) ? $request->localidades : -999;
	    
	    $productos = DB::table('sp_df_receta_detalle as d')
	    ->leftJoin('sp_df_receta as r', function($q) {
	        $q->on('r.folio', '=', 'd.folio');
	        $q->whereRaw('r.id_localidad = d.id_localidad');
	    })
	    ->leftJoin('cat_cuadro_producto as p','p.clave_cliente','d.clave_cliente')
	    ->selectRaw("p.clave_cliente as clave, max(p.descripcion) producto, sum(d.cantidad_surtida) cantidad, concat('#',substring(md5(random()::text) from 4 for 6)) as color")
	    ->whereBetween('r.fecha_folio', [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
	    ->groupBy(['p.clave_cliente'])->orderByRaw('cantidad desc')->limit(5)->get();
	    
	    $recetas = DB::table('sp_df_receta_detalle as d')
	    ->leftJoin('sp_df_receta as r', function($q) {
	        $q->on('r.folio', '=', 'd.folio');
	        $q->whereRaw('r.id_localidad = d.id_localidad');
	    })
	    ->leftJoin('cat_localidad as l','l.id_localidad','r.id_localidad')
	    ->leftJoin('cat_cuadro_producto as p','p.clave_cliente','d.clave_cliente')
	    ->selectRaw("r.folio as folio, l.localidad, max(p.descripcion) producto, sum(d.cantidad_surtida) cantidad, concat('#',substring(md5(random()::text) from 4 for 6)) as color")
	    ->whereBetween('r.fecha_folio', [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
	    ->groupBy(['r.folio', 'l.localidad'])->orderByRaw('cantidad desc')->limit(5)->get();
	    
	    
	    $medicos = DB::table('sp_df_receta_detalle as d')
	    ->leftJoin('sp_df_receta as r', function($q) {
	        $q->on('r.folio', '=', 'd.folio');
	        $q->whereRaw('r.id_localidad = d.id_localidad');
	    })
	    ->leftJoin('cat_medico_sp_df as m','m.id_medico','r.id_medico')
	    ->leftJoin('cat_cuadro_producto as p','p.clave_cliente','d.clave_cliente')
	    ->selectRaw("max(concat(m.nombre,' ',m.paterno,' ',m.materno)) as medico, p.clave_cliente as clave, max(p.descripcion) producto, sum(d.cantidad_surtida) cantidad, concat('#',substring(md5(random()::text) from 4 for 6)) as color")
	    ->whereBetween('r.fecha_folio', [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
	    ->whereRaw('r.id_medico is not null')->groupBy(['m.cedula', 'p.clave_cliente'])->orderByRaw('cantidad desc')->limit(15)->get();
	    
	    #dd($medicos);
	    
	    $pacientes = DB::table('sp_df_receta_detalle as d')
	    ->leftJoin('sp_df_receta as r', function($q) {
	        $q->on('r.folio', '=', 'd.folio');
	        $q->whereRaw('r.id_localidad = d.id_localidad');
	    })
	    ->leftJoin('cat_afiliado_sp_df as m','m.id_afiliacion','r.id_afiliacion')
	    ->leftJoin('cat_cuadro_producto as p','p.clave_cliente','d.clave_cliente')
	    ->selectRaw("max(concat(m.nombre,' ',m.paterno,' ',m.materno)) as paciente, p.clave_cliente as clave, max(p.descripcion) producto, sum(d.cantidad_surtida) cantidad, concat('#',substring(md5(random()::text) from 4 for 6)) as color")
	    ->whereBetween('r.fecha_folio', [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
	    ->whereRaw('r.id_afiliacion is not null')->groupBy(['m.id_afiliacion', 'p.clave_cliente'])->orderByRaw('cantidad desc')->limit(15)->get();
	    
	    return view('estadisticas.gastos.index',[
	        'localidades' => Localidades::where('id_cliente','=',135)->get()->pluck('localidad','id_localidad')->prepend('TODAS LAS LOCALIDADES','-999'),
	        'productos' => $productos,
	        'recetas' => $recetas,
	        'medicos' => $medicos,
	        'pacientes' => $pacientes,
	    ]);
	    
	    
	}
}