<?php
/**
 * Created by PhpStorm.
 * User: ihernandezt
 * Date: 04/09/2017
 * Time: 15:37
 */


namespace App\Http\Models\Captura;

use App\Http\Models\ModelBase;
use App\Http\Models\ModelCompany;

class Areas extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_area';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_area';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_area', 'area'];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
        'area' => 'required',
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
        'id area' => 'id_area',
        // 'empresa.nombre_comercial' => 'Empresa',
        // 'usuario.usuario' => 'Usuario',
        'area' => 'area',
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
