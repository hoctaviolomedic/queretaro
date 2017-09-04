<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AccionLog extends Model
{

    protected $connection = 'logs';

    protected $table = 'log_acciones';

    protected $primaryKey = 'id_accion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_accion','accion'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}