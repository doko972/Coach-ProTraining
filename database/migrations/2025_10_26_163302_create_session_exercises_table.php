<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0); // Ordre d'affichage
            $table->integer('sets'); // Nombre de séries (Ex: 4)
            $table->string('reps'); // Répétitions (Ex: "10-12", "max", "40s")
            $table->text('notes')->nullable(); // Notes spécifiques pour cet exercice
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_exercises');
    }
};
