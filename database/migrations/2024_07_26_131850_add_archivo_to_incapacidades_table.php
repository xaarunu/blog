<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchivoToIncapacidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incapacidades', function (Blueprint $table) {
            $table->foreignId('archivo')->nullable()->after('rpe');

            $table->foreign('archivo')->references('id')->on('archivos_generales')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign(['archivo']);

            $table->dropColumn('archivo');
        });
    }
}
