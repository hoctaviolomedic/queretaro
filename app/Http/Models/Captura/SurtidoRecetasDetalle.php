<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class SurtidoRecetasDetalle extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_surtido_receta_detalle';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_surtido_receta_detalle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_surtido_receta','id_receta_detalle','cantidad_surtida','precio_unitario'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [];

    public function surtidoreceta()
    {
        return $this->hasOne('App\Http\Models\Captura\SurtidoReceta','id_surtido_receta','id_surtido_receta');
    }

    public function recetadetalle()
    {
        return $this->hasOne('App\Http\Models\Captura\RecetasDetalle','id_receta_detalle','id_receta_detalle');
    }

}
