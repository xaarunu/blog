<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUserStateToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('estatus')->after('password')->default(1);
            $table->foreign('estatus', 'id_estatus')->references('id')->on('user_status')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('archivo')->references('id')->on('archivos_generales')->onUpdate('cascade')->onDelete('cascade');
        });

        // Actualizar estatus en registros previos (autorizados)
        DB::table('users')->update(['estatus' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_estatus']);
            $table->dropColumn('estatus');
        });
    }
}
