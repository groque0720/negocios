<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NegocioRedSocial extends Pivot
{
    protected $table = 'negocios_redes_sociales';
}
