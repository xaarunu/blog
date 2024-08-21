<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEstatusAtIncapacidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incapacidades', function (Blueprint $table) {
            $table->enum('estatus',['Pendiente','Aprobado','Rechazado'])->default('Pendiente')->after('diagnostico');
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
            $table->dropColumn('estatus');
        });
    }
}
