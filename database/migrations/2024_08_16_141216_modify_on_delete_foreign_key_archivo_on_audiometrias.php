<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOnDeleteForeignKeyArchivoOnAudiometrias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audiometrias', function (Blueprint $table) {
            // Eliminar foreign del archivo
            $table->dropForeign(['archivo']);

            // Agregar nuevamente ahora con onDelete restrict (No permita eliminar)
            $table->foreign('archivo')
                    ->references('id')
                    ->on('archivos_generales')
                    ->onUpdate('cascade')
                    ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audiometrias', function (Blueprint $table) {
            $table->dropForeign(['archivo']);

            $table->foreign('archivo')
                    ->references('id')
                    ->on('archivos_generales')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }
}
