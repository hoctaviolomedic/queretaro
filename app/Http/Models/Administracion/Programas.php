<?php

namespace App\Http\Models\Administracion;

use App\Http\Models\ModelCompany;

class Programas extends ModelCompany
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ss_qro_cat_programa';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_programa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The validation rules
     * @var array
     */
    public $rules = [
    ];

    /**
     * Los atributos que seran visibles en index-datable
     * @var array
     */
    protected $fields = [
    ];

    public function recetas()
    {
        return $this->hasMany('App\Http\Models\Captura\Recetas','id_programa','id_programa');
    }
}
