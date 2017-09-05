<?php

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Afiliaciones;
use App\Http\Models\Captura\Diagnosticos;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\Recetas;
use App\Http\Models\Captura\Usuarios;
use Illuminate\Support\Facades\Auth;
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
//        $this->localidades = DB::table('abisa.public.cat_localidad')
//            ->leftJoin('abisa.public.adm_usuario_localidad','abisa.public.adm_usuario_localidad.id_localidad','abisa.public.adm_usuario_localidad.id_localidad')
//            ->select('abisa.public.cat_localidad.id_localidad','abisa.public.cat_localidad.localidad')
//            ->where('abisa.public.adm_usuario_localidad.id_usuario','=',Auth::id())
//            ->where('abisa.public.cat_localidad.tipo','=',0)
//            ->where('abisa.public.cat_localidad.id_cliente','=',135)
//            ->get();
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
}