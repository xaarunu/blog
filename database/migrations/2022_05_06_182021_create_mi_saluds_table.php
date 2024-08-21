<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisaludsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mi_saluds', function (Blueprint $table) {
            $table->id();
            $table->string('rpe');
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->date('fecha');  
            $table->time('hora');
            $table->float('altura');
            $table->float('peso');
            $table->float('imc');
            $table->float('cintura');
            $table->float('cadera');
            $table->float('presionSis');
            $table->float('presionDia');
            $table->float('temperatura');
            $table->float('saturacion');
            $table->float('glucosa');
            $table->float('cardiaca');
            $table->float('respiratoria');
            $table->string('alergias');
            $table->text('tipo');
            $table->text('padecimientos');
            $table->text('observaciones'); 
            $table->text('diagnostico');
            $table->text('tratamiento'); 
            $table->string('foto_cuerpo');
            $table->string('foto_cara');
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
        Schema::dropIfExists('mi_saluds');
    }
}
