<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZonaColumnToIncapacidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incapacidades', function (Blueprint $table) {
            $table->string('subarea')->nullable()->after('rpe');
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
            $table->dropColumn('subarea');
        });
    }
}
