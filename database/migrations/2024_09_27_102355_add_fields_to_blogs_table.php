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
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('prioridad');
            $table->date('fecha_vencimiento')->default(now()); // Valor por defecto: fecha actual
            $table->string('imagen')->nullable();
            $table->integer('likes')->default(0); // Campo para los likes
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('prioridad');
            $table->dropColumn('fecha_vencimiento');
            $table->dropColumn('imagen');
            $table->dropColumn('likes');
            //
        });
    }
};
