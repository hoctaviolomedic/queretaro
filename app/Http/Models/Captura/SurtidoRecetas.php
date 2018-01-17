<?php

namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class SurtidoRecetas extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_surtido_receta';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_surtido_receta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_receta', 'id_usuario_creacion','observaciones','cancelado','motivo_cancelado','id_usuario_cancelado','fecha_cancelado'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [];
    
    #protected $eagerLoaders = ['receta.unidad_medica'];
    
    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'id_surtido_receta'=>'Folio de Surtido',
        'receta.unidad_medica' => 'Unidad Medica',
        'receta.folio'=>'Folio Receta',
        'receta.area.area'=>'Area',
        'receta.nombre_completo_medico'=>'Medico',
        'receta.nombre_completo_paciente'=>'Paciente',
        'receta.fecha_formated'=>'Fecha de Receta',
        'fecha_surtido_formated' => 'Fecha Surtido',
        'cancelado_text' => 'Estatus',
    ];

    public function getCanceladoTextAttribute()
    {
        return $this->cancelado ? 'Cancelado' : 'Surtido';
    }
    
    public function getFechaSurtidoFormatedAttribute(){
        return date("d-m-Y H:i:s",strtotime($this->fecha_surtido));
    }
    
    public function getSurtidoPorAttribute()
    {
        return $this->surtio->nombre.' '.$this->surtio->paterno.' '.$this->surtio->materno;
    }
    
    public function getCanceladoPorAttribute()
    {
        return ($this->canceladopor->nombre ?? '').' '.($this->canceladopor->paterno ?? '').' '.($this->canceladopor->materno ?? '');
    }

    public function detalles()
    {
        return $this->hasMany('App\Http\Models\Captura\SurtidoRecetasDetalle','id_surtido_receta','id_surtido_receta');
    }
    
    public function receta()
    {
        return $this->belongsTo('App\Http\Models\Captura\Recetas','id_receta','id_receta');
    }
    
    public function surtio()
    {
        return $this->hasOne('App\Http\Models\Administracion\Usuarios','id_usuario','id_usuario_creacion');
    }
    
    public function canceladopor()
    {
        return $this->hasOne('App\Http\Models\Administracion\Usuarios','id_usuario','id_usuario_cancelado');
    }
}
