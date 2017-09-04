<?php

namespace App\Http\Models;

use App\Http\Models\ModelBase;

class ModelCompany extends ModelBase
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection( request()->company );
    }
}
