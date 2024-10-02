<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Título del post
            $table->text('contenido'); // Contenido del post
            $table->string('rpe'); //  se define el RPE
            $table->foreign('rpe')->references('rpe')->on('users')->onDelete('cascade'); // Relacion con users
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
