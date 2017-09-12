<?php
/**
 * Created by PhpStorm.
 * User: ihernandezt
 * Date: 11/09/2017
 * Time: 13:15
 */


namespace App\Http\Models\Captura;

use App\Http\Models\ModelCompany;

class Estatus extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_estatus_requisicion';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_estatus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_estatus','estatus'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
        'id_estatus' => 'required',
        'estatus' => 'required',
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'id_estatus' => '#',
        'estatus' => 'Fecha captura',
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
