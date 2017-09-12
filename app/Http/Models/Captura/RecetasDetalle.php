<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class RecetasDetalle extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_receta_detalle';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_receta_detalle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_receta','clave_cliente','id_cuadro','cantidad_pedida','cantidad_surtida','dosis',
        'en_caso_presentar','recurrente','fecha_surtido','veces_surtir','veces_surtidas'];

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

    public function receta()
    {
        return $this->belongsTo('App\Http\Models\Captura\Receta','id_receta','id_receta');
    }

    public function producto()
    {
        return $this->hasOne('App\Http\Models\Captura\CuadroProductos','clave_cliente','clave_cliente');
    }

}
