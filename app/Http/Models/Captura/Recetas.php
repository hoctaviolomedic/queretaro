<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class Recetas extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_receta';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'folio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['folio','id_afiliacion', 'id_dependiente','id_medico','id_localidad'];

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
        'folio' => 'Folio'
    ];

    public function afiliacion()
    {
        return $this->belongsTo('App\Http\Models\Captura\Afiliacion','id_afiliacion','id_afiliacion');
    }

    public function diagnostico()
    {
        return $this->hasOne('App\Http\Models\Captura\Diagnosticos','id_diagnostico','id_diagnostico');
    }

    public function localidad()
    {
        return $this->belongsTo('App\Http\Models\Captura\Localidades','id_localidad','id_localidad');
    }
}
