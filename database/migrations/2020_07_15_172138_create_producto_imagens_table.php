<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoImagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_imagenes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id');
            $table->integer('posicion');
            $table->string('imagen');
            $table->string('descripcion')->nullable();
            $table->integer('confirmada')->default(0);
            $table->integer('borrar')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_imagens');
    }
}
