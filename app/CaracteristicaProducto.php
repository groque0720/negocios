<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaracteristicaProducto extends Pivot
{
    use SoftDeletes;
    protected $table = 'caracteristicas_productos';
}
