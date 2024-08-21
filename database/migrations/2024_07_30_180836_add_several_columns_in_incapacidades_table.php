<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeveralColumnsInIncapacidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incapacidades', function (Blueprint $table) {
            $table->text('diagnostico')->after('archivo');
            $table->text('observaciones')->nullable()->after('archivo');
            $table->string('matricula_doctor')->after('archivo');
            $table->string('certificado', 12)->after('archivo')->after('archivo');
            //
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
            $table->dropColumn('certificado');
            $table->dropColumn('matricula_doctor');
            $table->dropColumn('diagnostico');
            $table->dropColumn('observaciones');
            //
        });
    }
}
