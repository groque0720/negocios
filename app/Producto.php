<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    protected $table = 'productos';

    public function caracteristicas(){
    	return $this->belongsToMany(Caracteristica::class, 'caracteristicas_productos')->withPivot(['valor','posicion'])->orderBy('posicion');
    }

    public function categorias(){
    	return $this->belongsToMany(Categoria::class, 'categorias_productos')->withPivot('posicion')->orderBy('posicion');
    }

    public function imagenes(){
    	return $this->hasMany(ProductoImagen::class)->orderBy('posicion');
    }

    public function relacionados(){
        return $this->belongsToMany(Producto::class, 'productos_relaciones', 'album_id');
    }

}
