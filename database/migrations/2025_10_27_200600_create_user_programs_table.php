<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(true);
            $table->timestamps();
            
            // Un utilisateur ne peut avoir le même programme qu'une fois
            $table->unique(['user_id', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_programs');
    }
};