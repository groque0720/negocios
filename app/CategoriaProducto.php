<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoriaProducto extends Pivot
{
    protected $table = 'categorias_productos';
}
