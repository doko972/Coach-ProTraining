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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('week_id')->constrained()->onDelete('cascade');
            $table->integer('session_number'); // 1, 2, 3
            $table->string('name'); // Ex: "Séance 1"
            $table->string('focus')->nullable(); // Ex: "Pecs/Épaules/Triceps"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
