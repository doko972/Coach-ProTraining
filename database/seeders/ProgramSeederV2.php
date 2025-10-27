<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Week;
use App\Models\Session;
use App\Models\SessionExercise;
use App\Models\Exercise;

class ProgramSeederV2 extends Seeder
{
    public function run(): void
    {
        // =====================================
        // PROGRAMME 1 : CYCLE VOLUME
        // =====================================
        $volumeProgram = Program::create([
            'name' => 'Cycle VOLUME',
            'phase' => 'Volume',
            'description' => 'Programme d\'hypertrophie musculaire sur 4 semaines avec 3 séances par semaine.',
            'goal' => 'Prise de masse musculaire',
            'duration_weeks' => 4,
            'sessions_per_week' => 3,
            'is_active' => true,
        ]);

        // Semaine 1
        $week1 = Week::create([
            'program_id' => $volumeProgram->id,
            'week_number' => 1,
            'name' => 'Semaine 1',
        ]);

        $this->createSession($week1, 1, 'Séance 1', 'Pecs/Épaules/Triceps', [
            ['Développé couché barre', 4, '8-10'],
            ['Développé incliné haltères', 4, '10-12'],
            ['Développé militaire', 4, '8-10'],
            ['Élévations latérales', 3, '12-15'],
            ['Dips', 3, '10-12'],
        ]);

        $this->createSession($week1, 2, 'Séance 2', 'Jambes/Mollets/Core', [
            ['Squat', 4, '8-10'],
            ['Presse à cuisses', 4, '10-12'],
            ['Leg curl', 3, '12-15'],
            ['Mollets debout', 4, '15-20'],
            ['Planche', 3, '60s'],
        ]);

        $this->createSession($week1, 3, 'Séance 3', 'Dos/Biceps/Core', [
            ['Tractions', 4, '8-10'],
            ['Rowing barre', 4, '10-12'],
            ['Tirage horizontal', 3, '12-15'],
            ['Curl incliné', 3, '10-12'],
            ['Curl marteau', 3, '12-15'],
        ]);

        // Semaines 2, 3, 4 (copie de la structure)
        for ($weekNum = 2; $weekNum <= 4; $weekNum++) {
            $week = Week::create([
                'program_id' => $volumeProgram->id,
                'week_number' => $weekNum,
                'name' => "Semaine $weekNum",
            ]);

            $this->createSession($week, 1, 'Séance 1', 'Pecs/Épaules/Triceps', [
                ['Développé couché barre', 4, '8-10'],
                ['Développé incliné haltères', 4, '10-12'],
                ['Développé militaire', 4, '8-10'],
                ['Élévations latérales', 3, '12-15'],
                ['Dips', 3, '10-12'],
            ]);

            $this->createSession($week, 2, 'Séance 2', 'Jambes/Mollets/Core', [
                ['Squat', 4, '8-10'],
                ['Presse à cuisses', 4, '10-12'],
                ['Leg curl', 3, '12-15'],
                ['Mollets debout', 4, '15-20'],
                ['Planche', 3, '60s'],
            ]);

            $this->createSession($week, 3, 'Séance 3', 'Dos/Biceps/Core', [
                ['Tractions', 4, '8-10'],
                ['Rowing barre', 4, '10-12'],
                ['Tirage horizontal', 3, '12-15'],
                ['Curl incliné', 3, '10-12'],
                ['Curl marteau', 3, '12-15'],
            ]);
        }

        // =====================================
        // PROGRAMME 2 : CYCLE FORCE
        // =====================================
        $forceProgram = Program::create([
            'name' => 'Cycle FORCE',
            'phase' => 'Force',
            'description' => 'Programme orienté force sur 4 semaines avec charges lourdes.',
            'goal' => 'Développement de la force maximale',
            'duration_weeks' => 4,
            'sessions_per_week' => 4,
            'is_active' => true,
        ]);

        // Semaine 1
        $forceWeek1 = Week::create([
            'program_id' => $forceProgram->id,
            'week_number' => 1,
            'name' => 'Semaine 1',
        ]);

        $this->createSession($forceWeek1, 1, 'Séance 1', 'Développé couché', [
            ['Développé couché barre', 5, '5'],
            ['Développé incliné', 4, '6-8'],
            ['Dips lestés', 3, '8'],
        ]);

        $this->createSession($forceWeek1, 2, 'Séance 2', 'Squat', [
            ['Squat', 5, '5'],
            ['Front squat', 4, '6-8'],
            ['Leg extension', 3, '10'],
        ]);

        $this->createSession($forceWeek1, 3, 'Séance 3', 'Soulevé de terre', [
            ['Soulevé de terre', 5, '5'],
            ['Rowing barre', 4, '6-8'],
            ['Shrugs', 3, '10'],
        ]);

        $this->createSession($forceWeek1, 4, 'Séance 4', 'Développé militaire', [
            ['Développé militaire', 5, '5'],
            ['Développé nuque', 4, '6-8'],
            ['Élévations latérales', 3, '12'],
        ]);

        // Semaines 2, 3, 4 pour le programme Force
        for ($weekNum = 2; $weekNum <= 4; $weekNum++) {
            $forceWeek = Week::create([
                'program_id' => $forceProgram->id,
                'week_number' => $weekNum,
                'name' => "Semaine $weekNum",
            ]);

            $this->createSession($forceWeek, 1, 'Séance 1', 'Développé couché', [
                ['Développé couché barre', 5, '5'],
                ['Développé incliné', 4, '6-8'],
                ['Dips lestés', 3, '8'],
            ]);

            $this->createSession($forceWeek, 2, 'Séance 2', 'Squat', [
                ['Squat', 5, '5'],
                ['Front squat', 4, '6-8'],
                ['Leg extension', 3, '10'],
            ]);

            $this->createSession($forceWeek, 3, 'Séance 3', 'Soulevé de terre', [
                ['Soulevé de terre', 5, '5'],
                ['Rowing barre', 4, '6-8'],
                ['Shrugs', 3, '10'],
            ]);

            $this->createSession($forceWeek, 4, 'Séance 4', 'Développé militaire', [
                ['Développé militaire', 5, '5'],
                ['Développé nuque', 4, '6-8'],
                ['Élévations latérales', 3, '12'],
            ]);
        }

        // =====================================
        // PROGRAMME 3 : FULL BODY DÉBUTANT
        // =====================================
        $fullBodyProgram = Program::create([
            'name' => 'Full Body Débutant',
            'phase' => 'Initiation',
            'description' => 'Programme complet corps entier pour débutants, 3 séances par semaine.',
            'goal' => 'Apprentissage des mouvements et renforcement général',
            'duration_weeks' => 4,
            'sessions_per_week' => 3,
            'is_active' => true,
        ]);

        for ($weekNum = 1; $weekNum <= 4; $weekNum++) {
            $fbWeek = Week::create([
                'program_id' => $fullBodyProgram->id,
                'week_number' => $weekNum,
                'name' => "Semaine $weekNum",
            ]);

            $this->createSession($fbWeek, 1, 'Séance A', 'Corps complet', [
                ['Squat', 3, '10-12'],
                ['Développé couché', 3, '10-12'],
                ['Rowing barre', 3, '10-12'],
                ['Curl incliné', 2, '12-15'],
                ['Planche', 3, '45s'],
            ]);

            $this->createSession($fbWeek, 2, 'Séance B', 'Corps complet', [
                ['Soulevé de terre', 3, '8-10'],
                ['Développé militaire', 3, '10-12'],
                ['Tractions assistées', 3, '8-10'],
                ['Dips', 2, '10-12'],
                ['Abdominaux', 3, '15'],
            ]);

            $this->createSession($fbWeek, 3, 'Séance C', 'Corps complet', [
                ['Presse à cuisses', 3, '12-15'],
                ['Développé incliné', 3, '10-12'],
                ['Tirage horizontal', 3, '10-12'],
                ['Curl marteau', 2, '12-15'],
                ['Extensions triceps', 2, '12-15'],
            ]);
        }

        $this->command->info('✅ 3 programmes créés avec succès !');
    }

    // Fonction helper pour créer une séance
    private function createSession($week, $sessionNumber, $name, $focus, $exercises)
    {
        $session = Session::create([
            'week_id' => $week->id,
            'session_number' => $sessionNumber,
            'name' => $name,
            'focus' => $focus,
        ]);

        $order = 0;
        foreach ($exercises as $exerciseData) {
            $exercise = Exercise::where('name', $exerciseData[0])->first();
            
            if ($exercise) {
                SessionExercise::create([
                    'session_id' => $session->id,
                    'exercise_id' => $exercise->id,
                    'order' => $order++,
                    'sets' => $exerciseData[1],
                    'reps' => $exerciseData[2],
                ]);
            }
        }
    }
}