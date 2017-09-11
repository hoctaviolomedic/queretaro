<?php

namespace App\Http\Models\Captura;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_unidad_medida';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_unidad_medida';

}
