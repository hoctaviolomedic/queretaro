<?php

namespace App\Http\Models\Administracion;

use App\Http\Models\ModelCompany;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Usuarios extends ModelCompany implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'adm_usuario';

    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = 'id_usuario';

}