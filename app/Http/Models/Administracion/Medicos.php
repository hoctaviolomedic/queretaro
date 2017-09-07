<?php

namespace App\Http\Models\Administracion;

use App\Http\Models\ModelCompany;

class Medicos extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_medico_ss_qro';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_medico';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cedula','paterno', 'matenro','nombre','rfc','consultorio'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'cedula' => 'Fecha Receta',
        'paterno' => 'Apellido Paterno',
        'materno' => 'Apellido Matenro',
        'nombre' => 'Nombre',
        'rfc' => 'RFC'
    ];

    public function getNombreCompletoAttribute(){
        return $this->paterno.' '.$this->materno.' '.$this->nombre;
    }

    public function recetas()
    {
        return $this->hasMany('App\Http\Models\Captura\Recetas','id_medico','id_medico');
    }
}
