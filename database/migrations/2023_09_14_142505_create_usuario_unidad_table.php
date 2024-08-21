<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_unidad', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->string('rpe');
            $table->foreign('rpe')->references('rpe')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('unidad');
            $table->foreign('unidad')->references('id')->on('unidades_medicas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_unidad');
    }
}
