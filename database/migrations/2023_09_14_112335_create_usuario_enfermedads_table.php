<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioEnfermedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_enfermedads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enfermedades_cronicas_id');
            $table->string('rpe');
            $table->date('fecha_detectada')->nullable();
            $table->timestamps();

            $table->foreign('enfermedades_cronicas_id')
                    ->references('id')
                    ->on('enfermedades_cronicas')
                    ->onDelete('cascade');
            $table->foreign('rpe')
                    ->references('rpe')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_enfermedads');
    }
}
