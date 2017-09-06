<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class Usuarios extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'adm_usuarios';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_usuario';

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
    ];

    public function localidades()
    {
        return $this->belongsToMany('App\Http\Models\Captura\Localidades','adm_usuario_localidad','id_usuario','id_usuario');
    }
}
