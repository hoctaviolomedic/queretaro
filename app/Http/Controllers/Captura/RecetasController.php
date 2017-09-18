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
use Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Redirect;
use PDF;

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
        $this->localidades = Localidades::where('tipo',0)->where('id_cliente',135)->where('estatus',1)->get();

//        dd($this->localidades);

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

        if($request->presion1>0 && $request->presion2>0) {
            $request->request->set('presion', $request->presion1 . '/' . $request->presion2);
        }
        $request->request->set('id_estatus_receta', 1);
        $request->request->set('id_usuario_creacion', Auth::Id());
        $isSuccess = $this->entity->create($request->all());
        if ($isSuccess) {
            $id_receta = $isSuccess->id_receta;
            foreach ($request->_detalle as $detalle) {
                //Apartar
                $disponibles = DB::select("SELECT ie.codigo_barras,ie.quedan,ie.apartadas,ie.no_lote
                FROM cat_cuadro c
                INNER JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = '" . $detalle['clave_cliente'] . "'
                INNER JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
                INNER JOIN cat_localidad_producto lp ON lp.id_cuadro = C.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = " . $request->id_localidad . "
                INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                INNER JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
                INNER JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = C.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
                WHERE C.estatus = '1' AND C.id_tipo_cuadro = '1'
                GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,C.id_cuadro,lp.tope_receta,ie.codigo_barras,ie.caducidad,ie.quedan,ie.apartadas,ie.no_lote
                ORDER BY ie.caducidad ASC;");

                if ($disponibles[0]->quedan > $detalle['cantidad_pedida']) {
                    $index = 0;
                    while (true) {

                        $quedan = $disponibles[$index]->quedan;
                        $apartadas = $disponibles[$index]->apartadas;
                        $disponible = $quedan - ($apartadas + $detalle['cantidad_pedida']);
                        if ($disponible > 0) {//Si están disponibles las necesarias del con un mismo código de barras
                            $nuevo_disponible = $apartadas + $detalle['cantidad_pedida'];
                            $update = DB::update("UPDATE inv_existencia
                        SET apartadas = " . $nuevo_disponible . "
                        WHERE codigo_barras = '" . $disponibles[$index]->codigo_barras . "'
                        AND no_lote = '" . $disponibles[$index]->no_lote . "'
                        AND id_localidad = '" . $request->id_localidad . "'");
                            break;
                        }
                        $index++;
                    }
                }

                //Guardar detalle
                $detalle['cantidad_surtida'] = 0;
                $isSuccess->detalles()->save(new RecetasDetalle($detalle));
            }


           request()->session()->flash('printpdf', $id_receta );
            return redirect(companyRoute('index'))->with('printpdf', $id_receta);

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
        $data = $this->entity->findOrFail($id);
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];
        $id_localidad = $data->id_localidad;
        $localidad = Localidades::all()->where('id_localidad',$id_localidad)->pluck('localidad','id_localidad');

        $id_medico = $data->id_medico;
        $medico = Medicos::all()->where('id_medico',$id_medico)->pluck('nombre_completo','id_medico');

        $id_programa = $data->id_programa;
        $programa = Programas::all()->where('id_programa',$id_programa)->pluck('nombre_programa','id_programa');

        $id_afiliacion = $data->id_afiliacion;
        $id_dependiente = $data->id_dependiente;
        $afiliacion = Afiliaciones::all()->where('id_afiliacion',$id_afiliacion)->where('id_dependiente',$id_dependiente)->pluck('full_name','id_afiliacion');

        $id_area = $data->id_area;
        $area = Areas::all()->where('id_area',$id_area)->pluck('area','id_area');

        $id_diagnostico = $data->id_diagnostico;
        $diagnostico = Diagnosticos::all()->where('id_diagnostico',$id_diagnostico)->pluck('diagnostico','id_diagnostico');


        $presion = explode('/',$data->presion);

        return view(currentRouteName('smart'), $dataview+[
                'data' => $data,
                'localidades' => $localidad,
                'medicos' => $medico,
                'programas' => $programa,
                'afiliaciones' => $afiliacion,
                'areas' => $area,
                'diagnosticos' => $diagnostico,
                'presion1' => $presion[0],
                'presion2' => isset($presion[1])?$presion[1]:''
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
        $data = $this->entity->findOrFail($id);
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

        $programas[null] = 'Sin programa';
        $programas = $programas + $this->programas->pluck('nombre_programa','id_programa')->toArray();

        $id_afiliacion = $data->id_afiliacion;
        $id_dependiente = $data->id_dependiente;
        $afiliacion = Afiliaciones::all()->where('id_afiliacion',$id_afiliacion)->where('id_dependiente',$id_dependiente)->pluck('full_name','id_afiliacion');

        $id_area = $data->id_area;
        $area = Areas::all()->where('id_area',$id_area)->pluck('area','id_area');

        $id_diagnostico = $data->id_diagnostico;
        $diagnostico = Diagnosticos::all()->where('id_diagnostico',$id_diagnostico)->pluck('diagnostico','id_diagnostico');


        $presion = explode('/',$data->presion);

        return view(currentRouteName('smart'), $dataview+[
                'data' => $data,
                'localidades' => $this->localidades->pluck('localidad','id_localidad'),
                'medicos' => $this->medicos->pluck('nombre_completo','id_medico'),
                'programas' => $programas,
                'afiliaciones' => $afiliacion,
                'areas' => $this->areas->pluck('area','id_area'),
                'diagnosticos' => $diagnostico,
                'presion1' => $presion[0],
                'presion2' => $presion[1]
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
        $diagnosticos = Diagnosticos::where('diagnostico','LIKE','%'.$term.'%')->orWhere('clave_diagnostico','LIKE',$term.'%')->where('estatus','1')->get();
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
                tp.id_cuadro_tipo_medicamento as tipo_medicamento, c.id_cuadro, coalesce(cp.tope_receta,0) tope_receta

           FROM cat_cuadro c
            INNER JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.descripcion LIKE '%".$term."%'
            INNER JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
            INNER JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$request->localidad."
            INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
            INNER JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
            INNER JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'

           WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'

           GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,cp.tope_receta
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
                INNER JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = '".$data->clave_cliente."'
                INNER JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
                INNER JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$data->localidad."
                INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                INNER JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
                INNER JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
                WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'
                GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta
                ORDER BY disponible DESC, cp.descripcion;");

        return json_encode($query[0]);
    }

    public function verifyStockSurtir($company,Request $data){
        $query = DB::select("SELECT cp.clave_cliente, cp.descripcion, cf.descripcion as familia, coalesce(cp.cantidad_presentacion,0) cantidad_presentacion, coalesce(SUM(ie.quedan - ie.apartadas),0) disponible,
                tp.id_cuadro_tipo_medicamento as tipo_medicamento, c.id_cuadro, coalesce(lp.tope_receta,0) tope_receta
                FROM cat_cuadro c
                INNER JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = '".$data->clave_cliente."'
                INNER JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
                INNER JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$data->localidad."
                INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                INNER JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
                INNER JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
                WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'
                GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta
                ORDER BY disponible DESC, cp.descripcion;");
        return json_encode($query[0]);
    }

    public function surtirReceta($company,$id)
    {
        $receta = Recetas::all()->find($id);
        return view('captura.recetas.surtir',[
            'receta' => $receta,
        ]);
    }

    public function surtir($company,$id,Request $request)
    {
        foreach ($request->detalle as $detalle_actual) {
            $flag = true;
            $detalle = Recetas::all()->find($id)->detalles()->find($detalle_actual['id_receta_detalle']);
            $now = DB::select("select now()")[0]->now;
            if($detalle_actual['cantidadsurtir']>0){
                if(empty($detalle->fecha_surtido)) {//Si es la primer vez que se surte
                    $cantidad_nueva = $detalle->cantidad_surtida + $detalle_actual['cantidadsurtir'];
                    $veces_surtidas = $detalle->veces_surtidas;
                    if(($detalle->cantidad_pedida*$detalle->veces_surtir)%$detalle_actual['cantidadsurtir'] == 0 && $detalle_actual['cantidadsurtir']==$detalle->cantidad_pedida){
                        $veces_surtidas = $detalle->veces_surtidas + 1;
                    }
                    $detalle->update(['cantidad_surtida' => $cantidad_nueva,
                        'fecha_surtido'=>DB::select("select now()::TIMESTAMP(0) as fecha")[0]->fecha,
                        'veces_surtidas' => $veces_surtidas]);
                }elseif(!empty($detalle->fecha_surtido) && $detalle->recurrente>0 && $detalle->veces_surtidas < $detalle->veces_surtir){//Si no se ha llegado al límite y es recurrente
                    $fecha_surtido = $detalle->fecha_surtido;
                    if (DB::select("select date '" . $now . "' - date '" . $fecha_surtido . "' as diferencia")[0]->diferencia >= $detalle->recurrente) {
                        $cantidad_nueva = $detalle->cantidad_surtida + $detalle_actual['cantidadsurtir'];
                        $veces_surtidas = $detalle->veces_surtidas;
                        if($detalle->cantidad_pedida == $detalle_actual['cantidadsurtir'] || ($detalle->cantidad_pedida*$detalle->veces_surtir)%$detalle_actual['cantidadsurtir'] == 0){
                            $veces_surtidas = $detalle->veces_surtidas + 1;
                        }
                        $detalle->update(['cantidad_surtida' => $cantidad_nueva,
                            'fecha_surtido'=>DB::select("select now()::TIMESTAMP(0) as fecha")[0]->fecha,
                            'veces_surtidas'=>$veces_surtidas]);
                    }else{
                        $flag=false;
                    }
                }elseif(!empty($detalle->fecha_surtido) && $detalle->recurrente == 0 && $detalle->cantidad_surtida < $detalle->cantidad_pedida){
                    $cantidad_nueva = $detalle->cantidad_surtida + $detalle_actual['cantidadsurtir'];
                    $veces_surtidas = $detalle->veces_surtidas;
                    if($detalle->cantidad_pedida == $detalle_actual['cantidadsurtir'] || ($detalle->cantidad_pedida*$detalle->veces_surtir)/$cantidad_nueva == 1){
                        $veces_surtidas = $detalle->veces_surtidas + 1;
                    }
                    $detalle->update(['cantidad_surtida' => $cantidad_nueva,
                        'fecha_surtido'=>DB::select("select now()::TIMESTAMP(0) as fecha")[0]->fecha,
                        'veces_surtidas'=>$veces_surtidas]);
                }else{
                    $flag = false;
                }
            }
            if($flag){
                $disponibles = DB::select("SELECT ie.codigo_barras,ie.quedan,ie.apartadas,ie.no_lote
                FROM cat_cuadro c
                INNER JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135 AND cp.estatus = '1' AND cp.clave_cliente = '".$detalle['clave_cliente']."'
                INNER JOIN cat_cuadro_tipo_producto tp ON tp.id_cuadro_tipo_medicamento = cp.id_cuadro_tipo_medicamento AND tp.id_cuadro_tipo_medicamento <> 57 AND tp.estatus = '1'
                INNER JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.estatus = '1' AND lp.id_localidad = ".$request->id_localidad."
                INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                INNER JOIN inv_existencia ie ON ie.id_localidad = lp.id_localidad AND (ie.quedan - ie.apartadas > 0) AND ie.caducidad > now()
                INNER JOIN cat_producto_cliente pc ON pc.codigo_barras = ie.codigo_barras AND pc.id_cuadro = c.id_cuadro AND pc.clave_cliente = cp.clave_cliente AND pc.estatus = '1'
                WHERE c.estatus = '1' AND c.id_tipo_cuadro = '1'
                GROUP BY cp.clave_cliente,cp.descripcion,cf.descripcion,cp.cantidad_presentacion,tp.id_cuadro_tipo_medicamento,c.id_cuadro,lp.tope_receta,ie.codigo_barras,ie.caducidad,ie.quedan,ie.apartadas,ie.no_lote
                ORDER BY ie.caducidad ASC;");
                if ($disponibles[0]->quedan > 0) {
                    $index = 0;
                    while (true) {
                        $quedan = $disponibles[$index]->quedan;
                        $quedan = $quedan - $detalle_actual['cantidadsurtir'];
                        $apartadas = $disponibles[$index]->apartadas;
                        $apartadas = $apartadas - $detalle_actual['cantidadsurtir'];

                        $update = DB::update("UPDATE inv_existencia
                        SET apartadas = " . $apartadas . ", quedan = " . $quedan . "
                        WHERE codigo_barras = '" . $disponibles[$index]->codigo_barras . "'
                        AND no_lote = '" . $disponibles[$index]->no_lote . "'
                        AND id_localidad = '" . $request->id_localidad . "'");
                        $index++;
                        if ($update)
                            break;
                    }
                }
            }
        }
        return Redirect::back();
//        return view('captura.recetas.surtir',[
//            'receta' => $receta,
//        ]);
    }

    public function imprimirReceta($company,$id){
        $receta = Recetas::where('id_receta',$id)->first();
        $detalles = RecetasDetalle::where('id_receta',$id)->get();

        $qr = DNS2D::getBarcodePNG(asset(companyAction('show',['id'=>$receta->id_receta])), "QRCODE");
//        $barcode = '<img src="data:image/png,base64,' . DNS1D::getBarcodePNG("$solicitud->id_solicitud", "EAN8") . '" alt="barcode"   />';
//        $codigo = "<img width='150px' src='data:image/png;charset=binary;base64,".base64_encode($barcode)."' />";

//        dd($barcode);
        $pdf = PDF::loadView(currentRouteName('imprimir'),[
            'receta' => $receta,
            'detalles' => $detalles,
            'qr' => $qr
        ]);
        $pdf->setPaper('letter','landscape');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(38,580,"Página {PAGE_NUM} de {PAGE_COUNT}",null,8,array(0,0,0));
        $canvas->text(665,580,'RECETA MÉDICA',null,8);
//        $canvas->image('data:image/png;charset=binary;base64,'.$barcode,355,580,100,16);

        return $pdf->stream('solicitud')->header('Content-Type',"application/pdf");
    }
}