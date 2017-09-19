<?php
namespace App\Http\Controllers\Estadisticas;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\Jurisdicciones;
use DB;

class RequisicionesController extends ControllerBase
{
	public function index($company, $attributes = ['where'=>[]])
	{
	    return view('estadisticas.requisiciones.index',[
	        'jurisdicciones'=>Jurisdicciones::whereHas('localidades', function($q){ $q->where('id_cliente', '=', 135); })->get()->pluck('jurisdiccion','id_jurisdiccion')->prepend('TODAS LAS JURISDICCIONES','-999'),
	        'localidades' => Localidades::where('tipo',0)->where('id_cliente',135)->where('estatus',1)->get()->pluck('localidad','id_localidad')->prepend('TODOS LOS CENTROS DE SALUD','-999'),
	    ]);
	}
	
	public function store(Request $request, $company)
	{
	    $fecha_inicio = isset($request->datetimepicker1) ? $request->datetimepicker1 : '1900-01-01';
	    $fecha_fin = isset($request->datetimepicker2) ? $request->datetimepicker2 : '1900-01-01';
	    $jurisdiccion = isset($request->jurisdiccion) ? $request->jurisdiccion : -999;
	    $localidad = isset($request->localidad) ? $request->localidad : -999;
	    
	    $char1 = DB::table('ss_qro_requisicion as p')
    	    ->leftJoin('ss_qro_requisicion_detalle as d','d.id_requisicion','p.id_requisicion')
    	    ->leftJoin('cat_localidad as l', function($q) use($localidad){
    	        $q->on('l.id_localidad','=','p.id_localidad');
    	        $q->whereRaw("(l.id_localidad = $localidad or $localidad = -999)");
    	    })
    	    ->leftJoin('cat_jurisdiccion as j','j.id_jurisdiccion','l.id_jurisdiccion')
    	    ->leftJoin('cat_cuadro_producto as c', function($q) {
    	        $q->on('c.id_cuadro','=','d.id_cuadro');
    	        $q->whereRaw('c.clave_cliente = d.clave_cliente');
    	    })
    	    ->selectRaw('j.id_jurisdiccion, j.jurisdiccion, sum(d.cantidad_pedida)::numeric(10,0) as cantidad_pedida, sum(d.cantidad_surtida)::numeric(10,0) as cantidad_entregada,
                (sum(d.cantidad_pedida) - sum(d.cantidad_surtida))::numeric(10,0) as diferencia_cantidad,
                sum(d.cantidad_pedida * c.precio)::money::numeric as monto_pedido, sum(d.cantidad_surtida * c.precio)::money::numeric as monto_entregado,
                (sum(d.cantidad_pedida * c.precio) - sum(d.cantidad_surtida * c.precio))::money::numeric as diferencia_monto')
    	    ->where('l.id_cliente',135)
    	    ->where('l.tipo',0)
    	    ->where('l.estatus',1)
    	    ->whereNotNull('d.clave_cliente')
    	    ->whereBetween(DB::RAW("to_char(p.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])
    	    ->whereraw("(j.id_jurisdiccion = $jurisdiccion or $jurisdiccion = -999)")
    	    ->groupBy(['j.id_jurisdiccion','j.jurisdiccion'])
    	    ->orderBy('jurisdiccion')->get();
    	    
	    $char01 = DB::table('ss_qro_requisicion as p')
    	    ->leftJoin('ss_qro_requisicion_detalle as d','d.id_requisicion','p.id_requisicion')
    	    ->leftJoin('cat_localidad as l', function($q) use($localidad){
    	        $q->on('l.id_localidad','=','p.id_localidad');
    	        $q->whereRaw("(l.id_localidad = $localidad or $localidad = -999)");
    	    })
    	    ->leftJoin('cat_jurisdiccion as j','j.id_jurisdiccion','l.id_jurisdiccion')
    	    ->leftJoin('cat_cuadro_producto as c', function($q) {
    	        $q->on('c.id_cuadro','=','d.id_cuadro');
    	        $q->whereRaw('c.clave_cliente = d.clave_cliente');
    	    })
    	    ->selectRaw('j.jurisdiccion, l.localidad as centro_salud, sum(d.cantidad_pedida)::numeric(10,0) as cantidad_pedida, sum(d.cantidad_surtida)::numeric(10,0) as cantidad_entregada,
                (sum(d.cantidad_pedida) - sum(d.cantidad_surtida))::numeric(10,0) as diferencia_cantidad,
                sum(d.cantidad_pedida * c.precio)::money::numeric as monto_pedido, sum(d.cantidad_surtida * c.precio)::money::numeric as monto_entregado,
                (sum(d.cantidad_pedida * c.precio) - sum(d.cantidad_surtida * c.precio))::money::numeric as diferencia_monto')
                ->where('l.id_cliente',135)
                ->where('l.tipo',0)
                ->where('l.estatus',1)
                ->whereNotNull('d.clave_cliente')
                ->whereBetween(DB::RAW("to_char(p.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])
                ->whereraw("(j.id_jurisdiccion = $jurisdiccion or $jurisdiccion = -999)")
                ->groupBy(['j.jurisdiccion','l.localidad'])
                ->orderBy('jurisdiccion')->orderBy('centro_salud')->get();
    	    
        $char02 = DB::table('ss_qro_requisicion as p')
            ->leftJoin('ss_qro_requisicion_detalle as d','d.id_requisicion','p.id_requisicion')
            ->leftJoin('cat_area as a','a.id_area','d.id_area')
            ->leftJoin('cat_localidad as l', function($q) use($localidad){
                $q->on('l.id_localidad','=','p.id_localidad');
                $q->whereRaw("(l.id_localidad = $localidad or $localidad = -999)");
            })
            ->leftJoin('cat_jurisdiccion as j','j.id_jurisdiccion','l.id_jurisdiccion')
            ->leftJoin('cat_cuadro_producto as c', function($q) {
                $q->on('c.id_cuadro','=','d.id_cuadro');
                $q->whereRaw('c.clave_cliente = d.clave_cliente');
            })
            ->selectRaw("a.area, sum(d.cantidad_pedida)::numeric(10,0) as cantidad, sum(d.cantidad_pedida * c.precio)::money::numeric as monto,
                concat('#',substring(md5(random()::text) from 4 for 6)) as color")
            ->where('l.id_cliente',135)
            ->where('l.tipo',0)
            ->where('l.estatus',1)
            ->whereNotNull('d.clave_cliente')
            ->whereBetween(DB::RAW("to_char(p.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])
            ->whereraw("(j.id_jurisdiccion = $jurisdiccion or $jurisdiccion = -999)")
            ->groupBy(['a.area'])
            ->orderBy('area')->get();
	    
	    $char2 = DB::table('ss_qro_requisicion as p')
    	    ->leftJoin('ss_qro_requisicion_detalle as d','d.id_requisicion','p.id_requisicion')
    	    ->leftJoin('cat_localidad as l', function($q) use($localidad){
    	        $q->on('l.id_localidad','=','p.id_localidad');
    	        $q->whereRaw("(l.id_localidad = $localidad or $localidad = -999)");
    	    })
    	    ->leftJoin('cat_jurisdiccion as j','j.id_jurisdiccion','l.id_jurisdiccion')
    	    ->leftJoin('cat_cuadro_producto as c', function($q) {
    	        $q->on('c.id_cuadro','=','d.id_cuadro');
    	        $q->whereRaw('c.clave_cliente = d.clave_cliente');
    	    })
    	    ->selectRaw("d.clave_cliente, substring(c.descripcion from 1 for 200) as producto, sum(d.cantidad_pedida) as cantidad_pedida, sum(d.cantidad_pedida * c.precio)::numeric(10,2) as monto,
                concat('#',substring(md5(random()::text) from 4 for 6)) as color")
    	    ->where('l.id_cliente',135)
    	    ->where('l.tipo',0)
    	    ->where('l.estatus',1)
    	    ->whereNotNull('d.clave_cliente')
    	    ->whereBetween(DB::RAW("to_char(p.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])
    	    ->whereraw("(j.id_jurisdiccion = $jurisdiccion or $jurisdiccion = -999)")
    	    ->groupBy(['d.clave_cliente','c.descripcion'])
    	    ->orderBy('cantidad_pedida','desc')->limit(10)->get();
    	    
	    $char3 = DB::table('ss_qro_requisicion as p')
    	    ->leftJoin('ss_qro_requisicion_detalle as d','d.id_requisicion','p.id_requisicion')
    	    ->leftJoin('cat_localidad as l', function($q) use($localidad){
    	        $q->on('l.id_localidad','=','p.id_localidad');
    	        $q->whereRaw("(l.id_localidad = $localidad or $localidad = -999)");
    	    })
    	    ->leftJoin('cat_jurisdiccion as j','j.id_jurisdiccion','l.id_jurisdiccion')
    	    ->leftJoin('cat_cuadro_producto as c', function($q) {
    	        $q->on('c.id_cuadro','=','d.id_cuadro');
    	        $q->whereRaw('c.clave_cliente = d.clave_cliente');
    	    })
    	    ->selectRaw("d.clave_cliente, substring(c.descripcion from 1 for 200) as producto, sum(d.cantidad_pedida * c.precio)::numeric(10,2) as monto, sum(d.cantidad_pedida) as cantidad, concat('#',substring(md5(random()::text) from 4 for 6)) as color")
    	    ->where('l.id_cliente',135)
    	    ->where('l.tipo',0)
    	    ->where('l.estatus',1)
    	    ->whereNotNull('d.clave_cliente')
    	    ->whereBetween(DB::RAW("to_char(p.fecha, 'YYYY-MM-DD')"), [$fecha_inicio, $fecha_fin])
    	    ->whereraw("(j.id_jurisdiccion = $jurisdiccion or $jurisdiccion = -999)")
    	    ->groupBy(['d.clave_cliente','c.descripcion'])
    	    ->orderBy('monto','desc')->limit(10)->get();
	    
	    return view('estadisticas.requisiciones.index',[
	        'jurisdicciones'=>Jurisdicciones::whereHas('localidades', function($q){ $q->where('id_cliente', '=', 135); })->get()->pluck('jurisdiccion','id_jurisdiccion')->prepend('TODAS LAS JURISDICCIONES','-999'),
	        'localidades' => Localidades::where('id_cliente','=',135)->get()->pluck('localidad','id_localidad')->prepend('TODOS LOS CENTROS DE SALUD','-999'),
	        'char1' => $char1,
	        'char01' => $char01,
	        'char02' => $char02,
	        'char2' => $char2,
	        'char3' => $char3,
	    ]);
	}
	
	public function getLocalidades($company, Request $request)
	{
	    $jurisdiccion = $request->jurisdiccion;
	    $localidades = Localidades::where('tipo',0)->where('id_cliente',135)->where('estatus',1)
            ->whereraw("(id_jurisdiccion = $jurisdiccion or $jurisdiccion = -999)")
            ->get()->pluck('localidad','id_localidad')->prepend('TODOS LOS CENTROS DE SALUD','-999');
	    return json_encode($localidades->toJson());
	}
}