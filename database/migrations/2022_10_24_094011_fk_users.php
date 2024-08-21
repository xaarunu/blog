<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FkUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datosusers', function (Blueprint $table) {
            /*
            $table->foreign('rpe')
            ->references('rpe')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');*/

            $table->foreign('area')
            ->references('area_clave')
            ->on('areas')
            ->onUpdate('cascade');

            $table->foreign('subarea')
            ->references('subarea_clave')
            ->on('subareas')
            ->onUpdate('cascade');
        });
/*
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('rpe')
            ->references('rpe')
            ->on('datosusers')
            ->onUpdate('cascade')
            ->onDelete('cascade');

        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datosusers', function (Blueprint $table) {
            //$table->dropForeign('rpe');
            $table->dropForeign('datosusers_area_foreign');
            $table->dropForeign('datosusers_subarea_foreign');
        });
/*
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('rpe');
        });
        */
    }

}

