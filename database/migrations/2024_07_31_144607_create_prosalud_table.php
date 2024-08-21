<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProsaludTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prosalud', function (Blueprint $table) {
            $table->id();
            $table->string('rpe');
            $table->string('nombre');
            $table->date('fecha_toma');
            $table->integer('edad');
            $table->float('glucosa_resultado')->nullable();
            $table->string('glucosa_unidades');
            $table->string('glucosa_referencia');
            $table->float('trigliceridos_resultado')->nullable();
            $table->string('trigliceridos_unidades');
            $table->string('trigliceridos_referencia');
            $table->float('colesterol_resultado')->nullable();
            $table->string('colesterol_unidades');
            $table->string('colesterol_referencia');
            $table->float('hemoglobina_resultado')->nullable();
            $table->string('hemoglobina_unidades');
            $table->string('hemoglobina_referencia');
            $table->float('leucocitos_resultado')->nullable();
            $table->string('leucocitos_unidades');
            $table->string('leucocitos_referencia');
            $table->float('plaquetas_resultado')->nullable();
            $table->string('plaquetas_unidades');
            $table->string('plaquetas_referencia');
            $table->string('zona');
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
        Schema::dropIfExists('prosalud');
    }
}
