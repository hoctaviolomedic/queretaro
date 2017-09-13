<?php
/**
 * Created by PhpStorm.
 * User: ihernandezt
 * Date: 04/09/2017
 * Time: 12:21
 */

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;
use App\Http\Models\Captura\Localidades;
use App\Http\Models\Captura\Estatus;
use App\Http\Models\Administracion\Usuarios;

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
        'fecha_requerido' => 'required',
        'id_solicitante' => 'required',
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'folio' => '#',
        'localidad.localidad' => 'Localidad',
        'solicitante' => 'Solicitante',
        'fecha' => 'Fecha captura',
        'fecha_requerido' => 'Fecha requerimiento',
        'estatus.estatus' => 'Estatus',
    ];
    
    public function estatus()
    {
        return $this->hasOne(Estatus::class,'id_estatus','id_estatus');
    }
    
    public function localidad()
    {
        return $this->hasOne(Localidades::class,'id_localidad','id_localidad');
    }
    
    public function solicitantes()
    {
        return $this->hasOne(Usuarios::class,'id_usuario','id_solicitante');
    }
    
    public function getSolicitanteAttribute()
    {
        return $this->solicitantes->paterno.' '.$this->solicitantes->materno.' '.$this->solicitantes->nombre;
    }
    
}
