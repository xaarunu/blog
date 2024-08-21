<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosGeneralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos_generales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ruta');
            $table->string('hash')->unique();
            $table->string('nombre_archivo');
            $table->foreignId('tipo_archivo');
            $table->timestamps();

            $table->foreign('id_ruta')->references('id')->on('ubicaciones_archivos')->onUpdate('cascade');
            $table->foreign('tipo_archivo')->references('id')->on('file_types')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos_generales');
    }
}
