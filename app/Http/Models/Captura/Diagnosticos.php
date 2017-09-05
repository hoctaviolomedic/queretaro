<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class Diagnosticos extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abisa.public.cat_diagnostico';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_diagnostico';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = ['id_afiliacion','id_dependiente', 'paterno','materno','nombre','sexo','edad','genero','edad_tiempo'];

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
//        'nombre' => 'nombre'
    ];

}
