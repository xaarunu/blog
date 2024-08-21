<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesPrestadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_prestados', function (Blueprint $table) {
            $table->foreignId('id_entrega');
            $table->foreignId('id_rol');

            $table->unique(['id_entrega', 'id_rol']);
            $table->foreign('id_entrega')->references('id')->on('entrega_recepcion')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_rol')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_prestados');
    }
}
