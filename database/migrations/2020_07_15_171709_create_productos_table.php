<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->integer('negocio_id');
            $table->integer('tipo_id');//si es producto o albúm
            $table->string('producto');
            $table->text('descripcion')->nullable();
            $table->string('imagen_ppal')->nullable();
            $table->float('precio',11,2)->default(0)->nullable();
            $table->string('precio_obs')->nullable();
            $table->integer('activo')->default(1);
            $table->integer('guardar')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
