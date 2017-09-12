<?php

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Administracion\Medicos;
use App\Http\Models\Administracion\Programas;
use App\Http\Models\Captura\Afiliaciones;
use App\Http\Models\Captura\Areas;
use App\Http\Models\Captura\Diagnosticos;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\Recetas;
use App\Http\Models\Captura\RecetasDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RecetasController extends ControllerBase
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Recetas $entity)
    {
        $this->entity = $entity;
        $this->localidades = Localidades::where('tipo',0)->where('id_cliente',135)->where('id_usuario',3)->get();
        $this->medicos = Medicos::all();
        $this->programas = Programas::all();
        $this->areas = Areas::all();
    }

    public function index($company, $attributes = [])
    {
        $attributes = ['where'=>[]];
        return parent::index($company, $attributes);
    }

    public function getDataView()
    {
        return [
//             'companies' => Empresas::active()->select(['nombre_comercial','id_empresa'])->pluck('nombre_comercial','id_empresa'),
//             'users' => Usuarios::active()->select(['nombre_corto','id_usuario'])->pluck('nombre_corto','id_usuario')
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company, $attributes = [])
    {
        $programas[null] = 'Sin programa';
        $programas = $programas + $this->programas->pluck('nombre_programa','id_programa')->toArray();

        $attributes = $attributes +['dataview'=>[
                'localidades' => $this->localidades->pluck('localidad','id_localidad'),
                'medicos' => $this->medicos->pluck('nombre_completo','id_medico'),
                'programas' => $programas,
                'areas' => $this->areas->pluck('area','id_area')
            ]];
        return parent::create($company, $attributes);

//        return parent::create($company, [
//            'dataview' => $this->getDataView()
//        ]);
    }

    public function store(Request $request, $company)
    {
        # ¿Usuario tiene permiso para crear?
        // $this->authorize('create', $this->entity);


        # Validamos request, si falla regresamos pagina
        $this->validate($request, $this->entity->rules);

        $request->request->set('presion',$request->presion1.'/'.$request->presion2);
        $request->request->set('id_estatus_receta',1);
        $request->request->set('id_usuario_creacion',Auth::Id());
        $isSuccess = $this->entity->create($request->all());
        if ($isSuccess) {
            foreach ($request->_detalle as $detalle){
                //Apartar
                $disponibles = DB::select("SELECT ie.codigo_barras,ie.quedan,ie.apartadas,ie.no_lote
                FROM cat_cuadro c
                LEFT JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = '".$detalle['clave_cliente']."'
                LEFT JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
                LEFT JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$request->id_localidad."
                INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                LEFT JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
                LEFT JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
                WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'
                GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta,ie.codigo_barras,ie.caducidad,ie.quedan,ie.apartadas,ie.no_lote
                ORDER BY ie.caducidad ASC;");

                $index = 0;
                while(true){
                    $quedan = $disponibles[$index]->quedan;
                    $apartadas = $disponibles[$index]->apartadas;
                    $disponible = $quedan - ($apartadas+$detalle['cantidad_pedida']);
                    if($disponible>0){//Si están disponibles las necesarias del con un mismo código de barras
                        $nuevo_disponible = $apartadas+$detalle['cantidad_pedida'];
                        $update = DB::update("UPDATE inv_existencia
                        SET apartadas = ".$nuevo_disponible."
                        WHERE codigo_barras = '".$disponibles[$index]->codigo_barras."'
                        AND no_lote = '".$disponibles[$index]->no_lote."'
                        AND id_localidad = '".$request->id_localidad."'");
                        break;
                    }
                    $index++;
                }
                //Guardar detalle
//                dd($detalle);
                $detalle['cantidad_surtida']=0;
                $isSuccess->detalles()->save(new RecetasDetalle($detalle));
            }
            # Eliminamos cache
            Cache::tags(getCacheTag('index'))->flush();
//            $this->log('store', $isSuccess->id_receta);

            return $this->redirect('store');
        } else {
//            $this->log('error_store');
            return $this->redirect('error_store');
        }
    }

    /**
     * Display the specified resource
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($company, $id, $attributes = [])
    {
        return parent::show($company, $id, [
            'dataview' => $this->getDataView()
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

    public function getAfiliados($company,Request $request)
    {
        $json = [];
        $term = strtoupper($request->membership);
        $afiliados = Afiliaciones::where('id_afiliacion','LIKE',$term.'%')->orWhere(DB::raw("CONCAT(paterno,' ',materno, ' ',nombre)"),'LIKE','%'.$term.'%')->get();
        foreach ($afiliados as $afiliado){
            $json[] = ['id'=>$afiliado->id_dependiente,
                'text' => $afiliado->id_afiliacion." - ".$afiliado->paterno." ".$afiliado->materno." ".$afiliado->nombre,
                'afiliacion' => $afiliado->id_afiliacion];
        }
        return json_encode($json);
    }

    public function getDiagnosticos($company,Request $request)
    {
        $json = [];
        $term = strtoupper($request->diagnostico);
        $diagnosticos = Diagnosticos::where('diagnostico','LIKE','%'.$term.'%')->where('estatus','1')->get();
        foreach ($diagnosticos as $diagnostico){
            $json[] = ['id'=>$diagnostico->id_diagnostico,
                'text' => '('.$diagnostico->clave_diagnostico.') '.$diagnostico->diagnostico];
        }
        return json_encode($json);
    }

    public function getMedicamentos($company,Request $request)
    {
        $json = [];
        $term = strtoupper($request->medicamento);
        $medicamentos = DB::select("SELECT cp.clave_cliente, cp.descripcion, cf.descripcion as familia, coalesce(cp.cantidad_presentacion,0) cantidad_presentacion, coalesce(SUM(ie.quedan - ie.apartadas),0) disponible,
                tp.id_cuadro_tipo_medicamento as tipo_medicamento, c.id_cuadro, coalesce(lp.tope_receta,0) tope_receta
            
           FROM cat_cuadro c
            LEFT JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.descripcion LIKE '%".$term."%'
            LEFT JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
            LEFT JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$request->localidad."
            INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
            LEFT JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
            LEFT JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
            
           WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'
            
           GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta
            ORDER BY disponible DESC, cp.descripcion;");
        foreach ($medicamentos as $medicamento){
            $json[] = ['id'=>$medicamento->clave_cliente,
                'text' => $medicamento->descripcion,
                'cantidad_presentacion' => $medicamento->cantidad_presentacion,
                'familia'=>$medicamento->familia,
                'tope_receta'=>$medicamento->tope_receta,
                'disponible'=> $medicamento->disponible,
                'id_cuadro' => $medicamento->id_cuadro];
        }
        return json_encode($json);
    }

    public function verifyStock($company,Request $data){
        $query = DB::select("SELECT cp.clave_cliente, cp.descripcion, cf.descripcion as familia, coalesce(cp.cantidad_presentacion,0) cantidad_presentacion, coalesce(SUM(ie.quedan - ie.apartadas),0) disponible,
                tp.id_cuadro_tipo_medicamento as tipo_medicamento, c.id_cuadro, coalesce(lp.tope_receta,0) tope_receta            
                FROM cat_cuadro c
                LEFT JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = '".$data->clave_cliente."'
                LEFT JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
                LEFT JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$data->localidad."
                INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                LEFT JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
                LEFT JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
                WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'
                GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta
                ORDER BY disponible DESC, cp.descripcion;");

        return json_encode($query[0]);
    }

    public function surtirReceta($company,$id)
    {
        $receta = Recetas::all()->find($id);
//        $detalles = Recetas::all()->find($id)->detalles()->where('recurrente','>',0)->first();
        return view('captura\recetas\surtir',[
            'receta' => $receta,
//            'detalles' => $detalles
        ]);
    }

    public function surtir($company,$id)
    {
        $detalles = Recetas::all()->find($id)->detalles()->get();
        $medicamentos_surtidos = [];
        $medicamentos_no_surtidos = [];
        foreach ($detalles as $detalle) {
            $now = DB::select("select now()")[0]->now;
            if(empty($detalle->fecha_surtido) && $detalle->recurrente > 0) {//Si es la primer vez que se surte
                $cantidad_nueva = $detalle->cantidad_pedida + $detalle->cantidad_surtida;
                $detalle->update(['cantidad_surtida' => $cantidad_nueva,'fecha_surtido'=>DB::select("select now()::TIMESTAMP(0) as fecha")[0]->fecha]);
                array_push($medicamentos_surtidos,$detalle->clave_cliente);
            }elseif($detalle->fecha_surtido != null && $detalle->fecha_surtido != '' && $detalle->recurrente>0){
                $fecha_surtido = $detalle->fecha_surtido;
                if (DB::select("select date '" . $now . "' - date '" . $fecha_surtido . "' as diferencia")[0]->diferencia >= $detalle->recurrente) {
                    $cantidad_nueva = $detalle->cantidad_pedida + $detalle->cantidad_surtida;
                    $detalle->update(['cantidad_surtida' => $cantidad_nueva,'fecha_surtido'=>DB::select("select now()::TIMESTAMP(0) as fecha")[0]->fecha]);
                    array_push($medicamentos_surtidos,$detalle->clave_cliente);
                }else{
                    array_push($medicamentos_no_surtidos,$detalle->clave_cliente);
                }
            }else{
                array_push($medicamentos_no_surtidos,$detalle->clave_cliente);
            }
        }
        dump($medicamentos_surtidos);
        dump($medicamentos_no_surtidos);
        exit();
    }
}