<?php

namespace App;

use App\Caracteristica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Negocio extends Model
{
    use SoftDeletes;
    protected $table = 'negocios';

    public function negocio_completo() {
        return $this->redes_sociales();
    }

    public function categorias(){
    	return $this->hasMany(Categoria::class);
    }

    public function caracteristicas(){
    	return $this->hasMany(Caracteristica::class);
    }

    public function productos() {
    	return $this->hasMany(Producto::class);
    }

    public function redes_sociales(){
        return $this->belongsToMany(RedSocial::class, 'negocios_redes_sociales')->withPivot('url');;
    }
}
