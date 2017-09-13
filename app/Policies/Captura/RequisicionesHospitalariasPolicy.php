<?php

namespace App\Policies\Captura;

use App\Policies\PolicyBase;
use App\Http\Models\Administracion\Usuarios;

class RequisicionesHospitalariasPolicy extends PolicyBase
{

    public function delete(Usuarios $usuario)
    {
        return false;
    }
    public function update(Usuarios $usuario)
    {
        return false;
    }
    public function show(Usuarios $usuario)
    {
        return true;
    }
}