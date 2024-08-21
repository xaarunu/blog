<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudiometriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiometrias', function (Blueprint $table) {
            $table->id();
            $table->string('rpe');
            $table->date('fecha_toma');
            $table->foreignId('oido_izquierdo');
            $table->foreignId('oido_derecho');
            $table->foreignId('archivo');

            $table->foreign('rpe')->references('rpe')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('oido_izquierdo')->references('id')->on('tipos_resultados_audiometria')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('oido_derecho')->references('id')->on('tipos_resultados_audiometria')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('archivo')->references('id')->on('archivos_generales')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('audiometrias');
    }
}
