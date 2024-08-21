<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnsToMiSaludsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mi_saluds', function (Blueprint $table) {
            $table->dropColumn('foto_cuerpo');
            $table->dropColumn('foto_cara');
            $table->dropColumn('padecimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mi_saluds', function (Blueprint $table) {
            $table->string('foto_cuerpo');
            $table->string('foto_cara');
            $table->string('padecimientos');
        });
    }
}
