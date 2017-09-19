<?php

namespace App\Http\Models\Captura;

use Illuminate\Database\Eloquent\Model;

class Jurisdicciones extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_jurisdiccion';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_jurisdiccion';
    
    /**
     * Obtenemos jurisdiccion relacionads
     * @return relacion
     */
    public function localidades() {
        return $this->hasOne(Localidades::class, 'id_jurisdiccion', 'id_jurisdiccion');
    }

}
