<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncapacitadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacitados', function (Blueprint $table) {
            $table->id();
            $table->string('rpe');
            $table->date('fecha_deteccion');
            $table->string('area');
            $table->string('subarea')->nullable();
            $table->boolean('attended')->default(false);
            $table->timestamps();
        });
        Schema::table('incapacitados', function (Blueprint $table) {
            $table->renameColumn('fecha_deteccion', 'fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incapacitados');
        Schema::table('incapacitados', function (Blueprint $table) {
            $table->renameColumn('fecha', 'fecha_deteccion');
        });
    }
}
