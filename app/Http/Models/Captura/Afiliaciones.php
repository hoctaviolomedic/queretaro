<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class Afiliaciones extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abisa.public.cat_afiliado_ss_qro';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_afiliacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_afiliacion','id_dependiente', 'paterno','materno','nombre','sexo','edad','genero','edad_tiempo'];

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
        'nombre' => 'nombre'
    ];

    public function recetas()
    {
        return $this->hasMany('App\Http\Models\Captura\Recetas','id_afiliacion','id_afiliacion');
    }
}
