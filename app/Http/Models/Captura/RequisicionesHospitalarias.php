<?php
/**
 * Created by PhpStorm.
 * User: ihernandezt
 * Date: 04/09/2017
 * Time: 12:21
 */

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class RequisicionesHospitalarias extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_requerimiento';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_requerimiento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_localidad','fecha_captura','id_usuario_captura','id_area','tipo_producto','fecha_requerimiento','id_usuario_surtido'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
        'id_localidad' => 'required',
        'fecha_captura' => 'required',
        'id_usuario_captura' => 'required',
        'id_area' => 'required',
        'tipo_producto' => 'required',
        'fecha_requerimiento' => 'required',
        'id_usuario_surtido' => 'required'
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'id_requerimineto' => '#',
        'fecha_captura' => 'Fecha captura',
        'fecha_requerimiento' => 'Fecha requerimiento',
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
