<?php

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Afiliaciones;
use App\Http\Models\Captura\Diagnosticos;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\Recetas;
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
    public function create($company, $attributes = [])
    {
        $attributes = $attributes +['dataview'=>[
                'localidades' => $this->localidades->pluck('localidad','id_localidad')
            ]];
        return parent::create($company, $attributes);

//        return parent::create($company, [
//            'dataview' => $this->getDataView()
//        ]);
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
                'text' => $afiliado->id_afiliacion." - ".$afiliado->paterno." ".$afiliado->materno." ".$afiliado->nombre];
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
        $medicamentos = DB::select("SELECT cp.clave_cliente, cp.descripcion, cf.descripcion as familia, cp.cantidad_presentacion,TIPO_PRODUCTO.id_cuadro_tipo_medicamento as tipo_medicamento, c.id_cuadro, lp.tope_receta
                             FROM cat_cuadro c 
                             INNER JOIN cat_cuadro_producto cp ON cp.id_cuadro = c.id_cuadro AND c.id_cliente = 135
                             INNER JOIN cat_cuadro_tipo_producto TIPO_PRODUCTO ON cp.id_cuadro_tipo_medicamento = TIPO_PRODUCTO.id_cuadro_tipo_medicamento
                             INNER JOIN cat_localidad_producto lp ON lp.id_cuadro = c.id_cuadro AND lp.clave_cliente = cp.clave_cliente AND lp.id_localidad = ".$request->localidad."
                             INNER JOIN cat_familia cf ON cf.id_familia = cp.id_familia
                             WHERE cp.descripcion LIKE '%".$term."%'
                             AND c.estatus = '1'
                             AND c.id_tipo_cuadro = '1'
                             AND cp.estatus = '1'
                             AND TIPO_PRODUCTO.estatus = '1'
							 AND lp.estatus = '1'
                             AND TIPO_PRODUCTO.id_cuadro_tipo_medicamento <> 57
                             ORDER BY cp.descripcion
                             LIMIT 10;");
        foreach ($medicamentos as $medicamento){
            $json[] = ['id'=>$medicamento->clave_cliente,
                'text' => $medicamento->descripcion,
                'cantidad_presentacion' => $medicamento->cantidad_presentacion,
                'familia'=>$medicamento->familia];
        }
        return json_encode($json);
    }
}