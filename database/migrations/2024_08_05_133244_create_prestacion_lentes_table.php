<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestacionLentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestacion_lentes', function (Blueprint $table) {
            $table->id();
            $table->string('rpe', 5);
            $table->date('fecha_asignacion');
            $table->foreignId('archivo_id')->nullable();

            $table->foreign('rpe')->references('rpe')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('archivo_id')->references('id')->on('archivos_generales')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestacion_lentes');
    }
}
