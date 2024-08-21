<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioPendienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_pendiente', function (Blueprint $table) {
            $table->id();
            $table->string('rpe',5)->unique();
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno');
            $table->date('ingreso')->nullable();
            $table->date('antiguedad')->nullable();
            $table->string('contrato')->nullable();
            $table->boolean('confianza')->default(0);
            $table->string('puesto')->nullable();
            $table->string('division')->nullable();
            $table->string('area')->nullable()->default(null);
            $table->string('subarea');
            $table->timestamps();

            $table->foreign('division')
                ->references('division_clave')
                ->on('divisiones')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('area')
                ->references('area_clave')
                ->on('areas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('subarea')
                ->references('subarea_clave')
                ->on('subareas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_pendiente', function (Blueprint $table) {
            $table->dropForeign(['division']);
            $table->dropForeign(['area']);
            $table->dropForeign(['subarea']);
        });

        Schema::dropIfExists('usuario_pendiente');
    }
}
