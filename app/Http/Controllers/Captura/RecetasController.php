<?php

namespace App\Http\Controllers\Captura;

use App\Http\Controllers\ControllerBase;
use App\Http\Models\Captura\Recetas;

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
        return parent::create($company, [
            'dataview' => $this->getDataView()
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