<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaPrecioLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas_precios_lineas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lista_precio_id');
            $table->integer('producto_id');
            $table->string('descripcion')->nullable();
            $table->float('precio',11,2)->default(0)->nullable();
            $table->integer('en_promocion')->default(0);
            $table->string('tipo_promocion')->nullable();
            $table->float('precio_promocion',11,2)->default(0)->nullable();
            $table->integer('mostrar')->default(1);
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
        Schema::dropIfExists('lista_precio_lineas');
    }
}
