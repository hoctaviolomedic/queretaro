<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class EstatusRecetas extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_cat_estatus_receta';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_estatus_receta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = ['folio','id_afiliacion', 'id_dependiente','id_medico','id_localidad'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
//        'correo' => 'required|email',
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
    ];

}
