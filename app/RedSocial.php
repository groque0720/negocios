<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedSocial extends Model
{
    use SoftDeletes;
    protected $table = 'redes_sociales';
}
