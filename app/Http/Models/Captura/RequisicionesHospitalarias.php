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
    protected $table = 'ss_qro_requisicion';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_requisicion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_localidad','fecha','fecha_requerido','id_usuario_captura','id_usuario_modifica','fecha_modifica','id_estatus','id_solicitante' ];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
        'id_localidad' => 'required',
        'fecha' => 'required',
        'fecha_requerido' => 'required',
        'id_usuario_captura' => 'required',
        'id_usuario_modifica' => 'required',
        'fecha_modifica' => 'required',
        'id_estatus' => 'required',
        'id_solicitante' => 'required'
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'folio' => '#',
        'fecha' => 'Fecha captura',
        'fecha_requerido' => 'Fecha requerimiento',
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
