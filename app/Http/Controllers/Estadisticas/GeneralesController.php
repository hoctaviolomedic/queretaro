<?php
namespace App\Http\Controllers\Estadisticas;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Localidades;
use DB;

class GeneralesController extends ControllerBase
{
    public function index($company, $attributes = ['where'=>[]])
	{
	    return view('estadisticas.generales.index',[
	        'localidades' => Localidades::where('tipo',0)->where('id_cliente',135)->where('estatus',1)->get()->pluck('localidad','id_localidad')->prepend('TODAS LAS LOCALIDADES','-999'),
	        'padecimientos'=>[],
	        'pacientes' => [],
	        'medicos' => [],
	    ]);
	}
	
	public function store(Request $request, $company)
	{
	    $fecha_inicio = isset($request->datetimepicker1) ? $request->datetimepicker1 : '1900-01-01';
	    $fecha_fin = isset($request->datetimepicker2) ? $request->datetimepicker2 : '1900-01-01';
	    $localidad = isset($request->localidades) ? $request->localidades : -999;
	    
	    $padecimientos = DB::table('ss_qro_receta as r')->leftJoin('cat_diagnostico as d','d.id_diagnostico','r.id_diagnostico') //->leftJoin('ss_qro_receta as rd','rd.id_receta','r.id_receta')
    	    ->selectRaw('d.clave_diagnostico as clave, d.diagnostico as nombre, count(r.id_diagnostico) as total')
    	    ->whereBetween(DB::RAW("to_char(r.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
    	    ->groupBy(['r.id_diagnostico', 'd.diagnostico', 'd.clave_diagnostico'])->orderByRaw('Total desc')->limit(10)->get();
    	    
	    $pacientes = DB::table('ss_qro_receta as r')->leftJoin('cat_afiliado_sp_df as p','p.id_afiliacion','r.id_afiliacion')
            ->selectRaw("coalesce(p.id_afiliacion,'#N/A') as clave, coalesce(r.nombre_paciente_no_afiliado, concat(coalesce(p.nombre,''),' ',coalesce(p.paterno,''),' ',coalesce(p.materno,''))) as nombre, count(r.id_diagnostico) as total")
            ->whereBetween(DB::RAW("to_char(r.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
            ->groupBy(['r.id_diagnostico', 'p.nombre','p.paterno','p.materno', 'p.id_afiliacion','r.nombre_paciente_no_afiliado'])->orderByRaw('Total desc')->limit(10)->get();
	            
        $medicos = DB::table('ss_qro_receta as r')->leftJoin('cat_medico_sp_df as m','m.id_medico','r.id_medico')
            ->selectRaw("m.cedula, concat(m.nombre,' ',m.paterno,' ',m.materno) as nombre, count(r.id_diagnostico) as total")
            ->whereBetween(DB::RAW("to_char(r.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])->whereraw("(r.id_localidad = $localidad or $localidad = -999)")
            ->groupBy(['r.id_diagnostico', 'm.nombre','m.paterno','m.materno', 'm.cedula'])->orderByRaw('Total desc')->limit(10)->get();
        
	    return view('estadisticas.generales.index',[
	        'localidades' => Localidades::where('id_cliente','=',135)->get()->pluck('localidad','id_localidad')->prepend('TODAS LAS LOCALIDADES','-999'),
	        'padecimientos' => $padecimientos,
	        'pacientes' => $pacientes,
	        'medicos' => $medicos,
	    ]);
	}
}