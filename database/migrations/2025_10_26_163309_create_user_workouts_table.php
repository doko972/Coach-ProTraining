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
        Schema::create('user_workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('session_exercise_id')->constrained()->onDelete('cascade');
            $table->integer('set_number'); // Numéro de la série (1, 2, 3, 4)
            $table->decimal('weight', 8, 2)->nullable(); // Poids utilisé (Ex: 80.5 kg)
            $table->integer('reps')->nullable(); // Répétitions effectuées
            $table->boolean('completed')->default(false); // Série validée ou non
            $table->date('workout_date'); // Date de l'entraînement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_workouts');
    }
};
