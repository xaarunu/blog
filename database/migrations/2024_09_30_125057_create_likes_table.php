<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->string('rpe'); // El RPE es el identificador del usuario
            $table->foreignId('blog_id')->constrained()->onDelete('cascade'); // El blog que se está "likeando"
            $table->boolean('liked'); // True para like, False para dislike o quitar el like
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
