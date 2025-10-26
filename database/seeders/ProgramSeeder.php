<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Week;
use App\Models\Session;
use App\Models\SessionExercise;
use App\Models\Exercise;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        // Créer le programme
        $program = Program::create([
            'name' => 'Cycle VOLUME',
            'phase' => 'Phase 1 (Semaines 1-4)',
            'objective' => 'Hypertrophie - Volume',
            'description' => 'Programme de 4 semaines axé sur l\'hypertrophie avec volume élevé',
            'is_active' => true
        ]);

        // Créer les 4 semaines
        for ($weekNum = 1; $weekNum <= 4; $weekNum++) {
            $week = Week::create([
                'program_id' => $program->id,
                'week_number' => $weekNum,
                'name' => 'Semaine ' . $weekNum
            ]);

            // Séance 1 : Pecs/Épaules/Triceps
            $session1 = Session::create([
                'week_id' => $week->id,
                'session_number' => 1,
                'name' => 'Séance 1',
                'focus' => 'Pecs/Épaules/Triceps'
            ]);

            $this->addSessionExercises($session1, [
                ['name' => 'Développé couché haltères ou barre', 'sets' => 4, 'reps' => '10-12'],
                ['name' => 'Développé militaire assis', 'sets' => 3, 'reps' => '10'],
                ['name' => 'Élévations latérales + oiseau (superset)', 'sets' => 3, 'reps' => '15'],
                ['name' => 'Dips poulie ou banc', 'sets' => 3, 'reps' => '12'],
                ['name' => 'Extension triceps à la corde', 'sets' => 3, 'reps' => '15'],
            ]);

            // Séance 2 : Jambes/Mollets/Core
            $session2 = Session::create([
                'week_id' => $week->id,
                'session_number' => 2,
                'name' => 'Séance 2',
                'focus' => 'Jambes/Mollets/Core'
            ]);

            $this->addSessionExercises($session2, [
                ['name' => 'Squat ou Hack squat barre guidée', 'sets' => 4, 'reps' => '10'],
                ['name' => 'Fentes marchées haltères', 'sets' => 3, 'reps' => '12'],
                ['name' => 'Leg curl machine', 'sets' => 3, 'reps' => '12'],
                ['name' => 'Mollets debout', 'sets' => 4, 'reps' => '15'],
                ['name' => 'Gainage dynamique ou planche lestée', 'sets' => 3, 'reps' => '40s'],
            ]);

            // Séance 3 : Dos/Biceps/Core
            $session3 = Session::create([
                'week_id' => $week->id,
                'session_number' => 3,
                'name' => 'Séance 3',
                'focus' => 'Dos/Biceps/Core'
            ]);

            $this->addSessionExercises($session3, [
                ['name' => 'Tractions pronation ou tirage vertical', 'sets' => 4, 'reps' => '10-12'],
                ['name' => 'Rowing unilatéral haltère', 'sets' => 3, 'reps' => '12/bras'],
                ['name' => 'Curl incliné + marteau (superset)', 'sets' => 3, 'reps' => '10/10'],
                ['name' => 'Crunch avec disque ou poulie', 'sets' => 3, 'reps' => '15'],
                ['name' => 'Roue abdos (contrôlée)', 'sets' => 3, 'reps' => 'max'],
            ]);
        }
    }

    private function addSessionExercises($session, $exercises)
    {
        foreach ($exercises as $index => $exerciseData) {
            $exercise = Exercise::where('name', $exerciseData['name'])->first();
            
            if ($exercise) {
                SessionExercise::create([
                    'session_id' => $session->id,
                    'exercise_id' => $exercise->id,
                    'order' => $index + 1,
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                ]);
            }
        }
    }
}