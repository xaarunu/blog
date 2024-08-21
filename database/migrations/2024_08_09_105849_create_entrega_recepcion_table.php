<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaRecepcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_recepcion', function (Blueprint $table) {
            $table->id();
            $table->string('rpe_ausente', 5);
            $table->string('rpe_receptor', 5);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->text('motivo');
            $table->foreignId('id_archivo')->nullable();
            
            $table->timestamps();

            $table->foreign('rpe_ausente')->references('rpe')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rpe_receptor')->references('rpe')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_archivo')->references('id')->on('archivos_generales')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrega_recepcion');
    }
}
