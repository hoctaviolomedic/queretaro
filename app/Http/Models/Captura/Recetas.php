<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelBase;

class Recetas extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ges_det_correos';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_correo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['correo', 'fk_id_empresa', 'fk_id_usuario','activo'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
        'correo' => 'required|email',
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'correo' => 'Correo',
        // 'empresa.nombre_comercial' => 'Empresa',
        // 'usuario.usuario' => 'Usuario',
        'activo_span' => 'Estado',
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
