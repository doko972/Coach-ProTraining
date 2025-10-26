<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Liste des exercices
    public function index()
    {
        $exercises = Exercise::latest()->paginate(15);
        return view('admin.exercises.index', compact('exercises'));
    }

    // Formulaire de création
    public function create()
    {
        $categories = ['Pectoraux', 'Épaules', 'Triceps', 'Dos', 'Biceps', 'Jambes', 'Mollets', 'Abdos', 'Core'];
        $difficulties = ['Débutant', 'Intermédiaire', 'Avancé'];
        
        return view('admin.exercises.create', compact('categories', 'difficulties'));
    }

    // Enregistrer un nouvel exercice
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|max:255',
        ]);

        Exercise::create($validated);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercice créé avec succès !');
    }

    // Afficher un exercice
    public function show(Exercise $exercise)
    {
        $exercise->load('sessionExercises.session.week.program');
        return view('admin.exercises.show', compact('exercise'));
    }

    // Formulaire d'édition
    public function edit(Exercise $exercise)
    {
        $categories = ['Pectoraux', 'Épaules', 'Triceps', 'Dos', 'Biceps', 'Jambes', 'Mollets', 'Abdos', 'Core'];
        $difficulties = ['Débutant', 'Intermédiaire', 'Avancé'];
        
        return view('admin.exercises.edit', compact('exercise', 'categories', 'difficulties'));
    }

    // Mettre à jour un exercice
    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|max:255',
        ]);

        $exercise->update($validated);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercice modifié avec succès !');
    }

    // Supprimer un exercice
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercice supprimé avec succès !');
    }
}