<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncapacidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('ramo_de_seguro');
            $table->integer('dias_autorizados');
            $table->integer('dias_acumulados');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('nombre_doctor');
            $table->string('rpe');
            $table->foreign('rpe')->references('rpe')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('incapacidades');
    }
}
