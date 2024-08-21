<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteMoreColumnsToPersonalesTable  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personales', function (Blueprint $table) {
            $table->dropColumn(['fum', 'para', 'aborto', 'cesaria', 'ets', 'anticonceptivos', 'pap']);
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personales', function (Blueprint $table) {
            $table->string('menarca');
            $table->integer('fum');
            $table->integer('para');
            $table->integer('aborto');
            $table->integer('cesaria');
            $table->string('ets');
            $table->string('anticonceptivos');
            $table->date('pap');
        });
    }
}
