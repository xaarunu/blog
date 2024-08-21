<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullTExtToDatosuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datosusers', function (Blueprint $table) {
            $table->fullText(['nombre', 'paterno', 'materno']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datosusers', function (Blueprint $table) {
            $table->dropFullText(['nombre', 'paterno', 'materno']);
        });
    }
}
