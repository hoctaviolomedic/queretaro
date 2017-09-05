<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class Localidades extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_localidad';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_localidad';

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

    public function usuarios()
    {
        return $this->hasMany('App\Http\Models\Captura\Usuarios','id_localidad','id_localidad');
    }
}
