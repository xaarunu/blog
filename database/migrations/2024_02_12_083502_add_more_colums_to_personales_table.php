<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumsToPersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personales', function (Blueprint $table) {
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo')->nullable();
            $table->float('altura')->nullable();
            $table->float('peso')->nullable();
            $table->float('imc')->nullable();
            $table->float('cintura')->nullable();
            $table->float('cadera')->nullable();
            $table->float('presionSis')->nullable();
            $table->float('presionDia')->nullable();
            $table->float('glucosa')->nullable();
            $table->string('alergias')->nullable();
            $table->text('tipo')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
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
            $table->dropColumn([
                'fecha_nacimiento',
                'sexo',
                'altura',
                'peso',
                'imc',
                'cintura',
                'cadera',
                'presionSis',
                'presionDia',
                'glucosa',
                'alergias',
                'tipo',
                'observaciones',
                'diagnostico',
                'tratamiento'
            ]);
        });
    }
}
