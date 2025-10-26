<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            // Pectoraux
            ['name' => 'Développé couché haltères ou barre', 'category' => 'Pectoraux', 'difficulty' => 'Intermédiaire'],
            
            // Épaules
            ['name' => 'Développé militaire assis', 'category' => 'Épaules', 'difficulty' => 'Intermédiaire'],
            ['name' => 'Élévations latérales + oiseau (superset)', 'category' => 'Épaules', 'difficulty' => 'Intermédiaire'],
            
            // Triceps
            ['name' => 'Dips poulie ou banc', 'category' => 'Triceps', 'difficulty' => 'Intermédiaire'],
            ['name' => 'Extension triceps à la corde', 'category' => 'Triceps', 'difficulty' => 'Débutant'],
            
            // Jambes
            ['name' => 'Squat ou Hack squat barre guidée', 'category' => 'Jambes', 'difficulty' => 'Avancé'],
            ['name' => 'Fentes marchées haltères', 'category' => 'Jambes', 'difficulty' => 'Intermédiaire'],
            ['name' => 'Leg curl machine', 'category' => 'Jambes', 'difficulty' => 'Débutant'],
            
            // Mollets
            ['name' => 'Mollets debout', 'category' => 'Mollets', 'difficulty' => 'Débutant'],
            
            // Core
            ['name' => 'Gainage dynamique ou planche lestée', 'category' => 'Core', 'difficulty' => 'Intermédiaire'],
            
            // Dos
            ['name' => 'Tractions pronation ou tirage vertical', 'category' => 'Dos', 'difficulty' => 'Avancé'],
            ['name' => 'Rowing unilatéral haltère', 'category' => 'Dos', 'difficulty' => 'Intermédiaire'],
            
            // Biceps
            ['name' => 'Curl incliné + marteau (superset)', 'category' => 'Biceps', 'difficulty' => 'Intermédiaire'],
            
            // Abdos
            ['name' => 'Crunch avec disque ou poulie', 'category' => 'Abdos', 'difficulty' => 'Débutant'],
            ['name' => 'Roue abdos (contrôlée)', 'category' => 'Abdos', 'difficulty' => 'Avancé'],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}