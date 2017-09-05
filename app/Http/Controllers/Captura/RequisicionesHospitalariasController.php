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
use App\Http\Models\Captura\Usuarios;
use App\Http\Models\Captura\Productos;
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

        $localidades = Localidades::all()->pluck('localidad','id_localidad');
        //$localidades = Localidades::all();
        $producto_licitacion = ProductosLicitacion::all()->pluck('descripcion','id_tipo_producto');
        $areas = Areas::all()->pluck('area','id_area');
        $usuarios = Usuarios::select(DB::raw("CONCAT(nombre,' ',paterno,' ',materno) AS nombre"),'id_usuario')
            ->pluck('nombre','id_usuario');
        $productos = Productos::select(DB::raw("CONCAT(clave,' - ',nombre_comercial) AS nombre"),'clave')
            ->pluck('nombre','clave');
        $dataview = isset($attributes['dataview']) ? $attributes['dataview'] : [];

        return view(currentRouteName('smart'), $dataview+[
            'data'=>$data,
            'localidades'=>$localidades,
            'producto_licitacion'=>$producto_licitacion,
            'areas'=>$areas,
            'solicitante'=>$usuarios,
            'productos'=>$productos,

            ]);
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
}