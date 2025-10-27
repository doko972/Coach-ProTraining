<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Vérifier si les colonnes n'existent pas déjà avant de les ajouter
            if (!Schema::hasColumn('programs', 'goal')) {
                $table->string('goal')->nullable()->after('description');
            }
            if (!Schema::hasColumn('programs', 'duration_weeks')) {
                $table->integer('duration_weeks')->default(4)->after('goal');
            }
            if (!Schema::hasColumn('programs', 'sessions_per_week')) {
                $table->integer('sessions_per_week')->default(3)->after('duration_weeks');
            }
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['goal', 'duration_weeks', 'sessions_per_week']);
        });
    }
};