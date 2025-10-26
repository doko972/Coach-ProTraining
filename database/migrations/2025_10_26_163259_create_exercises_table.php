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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Développé couché haltères ou barre"
            $table->text('description')->nullable();
            $table->string('category')->nullable(); // Ex: "Pectoraux", "Dos", "Jambes"
            $table->string('difficulty')->nullable(); // Ex: "Débutant", "Intermédiaire", "Avancé"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
