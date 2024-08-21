<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUMFColumnsToIncapacidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incapacidades', function (Blueprint $table) {
            // Se hace nullable por los registros de incapacidades ya creados previamente
            $table->foreignId('umf_id')->after('nombre_doctor')->nullable();
            $table->integer('consultorio')->after('umf_id')->nullable();
            $table->string('turno')->after('consultorio')->nullable();

            $table->foreign('umf_id')->references('id')->on('unidades_medicas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incapacidades', function (Blueprint $table) {
            $table->dropForeign(['umf_id']);
            $table->dropColumn(['umf_id', 'consultorio', 'turno']);
        });
    }
}
