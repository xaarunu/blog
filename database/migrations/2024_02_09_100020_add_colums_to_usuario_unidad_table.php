<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToUsuarioUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_unidad', function (Blueprint $table) {
            $table->string('consultorio')->nullable();
            $table->string('turno')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_unidad', function (Blueprint $table) {
            $table->dropColumn(['consultorio', 'turno']);
        });
    }
}
