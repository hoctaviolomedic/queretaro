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
    protected $table = 'abisa.public.ss_qro_receta';

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
    protected $fillable = ['id_afiliacion', 'id_dependiente','id_medico','id_localidad'];

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
        'id_afiliacion' => 'Afiliacion',
        'id_dependiente' => 'Dependiente',
        'id_medico' => 'Médico',
        'id_localidad' => 'Localidad'
    ];

    /**
     * Atributos de carga optimizada
     * @var array
     */
    // protected $eagerLoaders = ['empresa', 'usuario'];

    /**
     * Obtenemos usuario relacionado
     * @return Usuario
     */
    // public function usuario()
    // {
    //     return $this->belongsTo(Usuarios::class, 'fk_id_usuario', 'id_usuario');
    // }

    /**
     * Obtenemos empresa relacionada
     * @return Empresa
     */
    // public function empresa()
    // {
    //     return $this->belongsTo(Empresas::class, 'fk_id_empresa', 'id_empresa');
    // }
}
