<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelBase;

class TiposDeProductos extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_tipo_producto';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_tipo';

    /**
     * The validation rules
     * @var array
     */
    public $rules = [];

}
