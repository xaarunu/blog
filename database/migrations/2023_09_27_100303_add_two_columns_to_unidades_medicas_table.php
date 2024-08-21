<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoColumnsToUnidadesmedicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unidades_medicas', function (Blueprint $table) {
            $table->string('estado');
            $table->string('municipio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidades_medicas', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('municipio');
        });
    }
}
