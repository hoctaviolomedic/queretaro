<?php
/**
 * Created by PhpStorm.
 * User: ihernandezt
 * Date: 04/09/2017
 * Time: 12:37
 */

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Areas;
use App\Http\Models\Captura\RequisicionesHospitalarias;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\ProductosLicitacion;
use App\Http\Models\Administracion\Usuarios;
use App\Http\Models\Captura\Productos;
use Illuminate\Http\Request;
use DB;

class RequisicionesHospitalariasController extends ControllerBase
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RequisicionesHospitalarias $entity)
    {
        $this->entity = $entity;
    }

    public function getDataView()
    {
        return [
            // 'companies' => Empresas::active()->select(['nombre_comercial','id_empresa'])->pluck('nombre_comercial','id_empresa'),
            // 'users' => Usuarios::active()->select(['nombre_corto','id_usuario'])->pluck('nombre_corto','id_usuario')
        ];
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
        $localidades = Localidades::where('tipo',0)->where('id_cliente',92)->pluck('localidad','id_localidad');
//        $localidades = Localidades::where('tipo',0)->where('id_cliente',135)->where('id_usuario',3)->pluck('localidad','id_localidad');
//        $localidades->first('');
        //        $producto_licitacion = ProductosLicitacion::all()->pluck('descripcion','id_tipo_producto');
//        $areas = Areas::all()->pluck('area','id_area');
////        $areas = Areas::join('cat_localidad','cat_area.idarea','=','cat_localidad')->pluck('area','id_area');
//
//        $usuarios = Usuarios::select(DB::raw("CONCAT(nombre,' ',paterno,' ',materno) AS nombre"),'id_usuario')
//            ->pluck('nombre','id_usuario');
//        $productos = Productos::select(DB::raw("CONCAT(clave,' - ',nombre_comercial) AS nombre"),'clave')
//            ->pluck('nombre','clave');
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

        return view(currentRouteName('smart'), $dataview+[
            'data'=>$data,
            'localidades'=>$localidades,
//            'producto_licitacion'=>$producto_licitacion,
//            'areas'=>$areas,
//            'solicitante'=>$usuarios,
//            'productos'=>$productos,

            ]);
    }

    public function store(Request $request, $company)
    {


        $id_max = RequisicionesHospitalarias::all()->max('id_requerimiento');
//        $request->all()->merge(['id_requisicion' => $id_max]);

//        dd($request->all());
        $isSuccess = $this->entity->create($request->all()+['id_requerimiento' => $id_max+1]);
        $cont_id = DB::table('ss_qro_requerimiento_detalle')->max('id_requerimiento')+1;
        foreach ($request->input('producto_requisicion') as $productos_requiscion )
        {
            dump($cont_id);
            DB::table('ss_qro_requerimiento_detalle')->insert([
                'id_requerimiento' => $cont_id ,
                'id_qro_requerimiento' => $id_max+1,
                'id_localidad' => $request->id_localidad,
                'clave_cliente' => $productos_requiscion['producto_clave'],
                'id_cuadro' => 155,
                'cantidad_pedida' => $productos_requiscion['cantidad'],
                'cantidad_surtida' => 0,
                'id_area' => $productos_requiscion['id_area'],
                'clave_producto' => $productos_requiscion['producto_clave'],
            ]);
            $cont_id++;
        }


//        $this->validate($request, $this->entity->rules);
//
//        $isSuccess = $this->entity->create($request->all());
//        if ($isSuccess) {
//
//            # Eliminamos cache
//            Cache::tags(getCacheTag('index'))->flush();
//
//            $this->log('store', $isSuccess->id_banco);
            return $this->redirect('store');
//        } else {
//            $this->log('error_store');
//            return $this->redirect('error_store');
//        }
    }

    /**
     * Display the specified resource
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($company, $id, $attributes = [])
    {

        $datos_requerimiento = RequisicionesHospitalarias::all()->where('id_requerimiento','=',$id)->first();

        $localidad = RequisicionesHospitalarias::join('cat_localidad','ss_qro_requerimiento.id_localidad','=','cat_localidad.id_localidad')
            ->where('ss_qro_requerimiento.id_requerimiento','=',$id)
            ->select('cat_localidad.id_localidad','cat_localidad.localidad')
            ->get();

        $usuario = RequisicionesHospitalarias::join('adm_usuario','ss_qro_requerimiento.id_usuario_surtido','=','adm_usuario.id_usuario')
            ->select(DB::raw("CONCAT(adm_usuario.nombre,' ',adm_usuario.paterno,' ',adm_usuario.materno) AS nombre"))
            ->where('ss_qro_requerimiento.id_requerimiento','=',$id)
            ->pluck('nombre');


        $detalle_requerimiento = DB::select("SELECT rd.*, a.area, cp.descripcion
            FROM ss_qro_requerimiento_detalle as rd
            LEFT JOIN cat_area as a ON a.id_area = rd.id_area
            LEFT JOIN cat_cuadro c ON C.id_cuadro = rd.id_cuadro
            LEFT JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = rd.clave_cliente
            WHERE rd.id_qro_requerimiento = $id");


//        dd($detalle_requerimiento);

        $data = $this->entity->findOrFail($id);
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

        return view(currentRouteName('smart'), $dataview+[
            'data'=>$data,
            'localidades'=>$localidad->pluck('localidad','id_localidad'),
//            'producto_licitacion'=>$datos_productos,
//            'areas'=>$areas,
            'solicitante'=>$usuario,
            'datos_requerimiento'=> $datos_requerimiento,
            'detalle_requerimiento'=> $detalle_requerimiento,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($company, $id, $attributes = [])
    {
        return parent::edit($company, $id, [
            'dataview' => $this->getDataView()
        ]);
    }

//    public function getAreas()
    public function getAreas()
    {
        $json = [];

        $areas = Areas::join('cat_area_localidad','cat_area.id_area','=','cat_area_localidad.id_area')
            ->where('cat_area_localidad.id_localidad','=',$_POST['id_localidad'])
            ->pluck('cat_area.area','cat_area_localidad.id_area')
            ->toJson();


        $usuarios =Usuarios::join('adm_usuario_localidad','adm_usuario.id_usuario','=','adm_usuario.id_usuario')
            ->where('adm_usuario_localidad.id_localidad','=',$_POST['id_localidad'])
            ->select(DB::raw("CONCAT(adm_usuario.nombre,' ',adm_usuario.paterno,' ',adm_usuario.materno) AS nombre"),'adm_usuario.id_usuario')
            ->pluck('nombre','id_usuario')
            ->toJson();

        $productos = DB::select("SELECT cp.clave_cliente, cp.descripcion, cf.descripcion as familia, coalesce(cp.cantidad_presentacion,0) cantidad_presentacion, coalesce(SUM(ie.quedan - ie.apartadas),0) disponible,
                tp.id_cuadro_tipo_medicamento as tipo_medicamento, c.id_cuadro, coalesce(lp.tope_receta,0) tope_receta
            FROM cat_cuadro c
            LEFT JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1'
            LEFT JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
            LEFT JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$_POST['id_localidad']."
            INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
            LEFT JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
            LEFT JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
            WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1' AND C.id_cliente = 135
            GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta
            ORDER BY disponible DESC, cp.descripcion;");

        foreach ($productos as $producto){
            $json[$producto->clave_cliente] = $producto->descripcion;
        }

        $json = json_encode($json);
        $areas = ['areas'=>$areas,'usuario'=>$usuarios,'producto'=>$json];

        return json_encode($areas);
    }


}