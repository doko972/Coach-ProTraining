<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Week;
use App\Models\Exercise;
use App\Models\SessionExercise;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    // Liste des séances
    public function index()
    {
        $sessions = Session::with(['week.program'])
            ->latest()
            ->paginate(15);
        
        return view('admin.sessions.index', compact('sessions'));
    }

    // Formulaire de création
    public function create()
    {
        $weeks = Week::with('program')->get();
        $exercises = Exercise::orderBy('name')->get();
        
        return view('admin.sessions.create', compact('weeks', 'exercises'));
    }

    // Enregistrer une nouvelle séance
    public function store(Request $request)
    {
        $validated = $request->validate([
            'week_id' => 'required|exists:weeks,id',
            'session_number' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'focus' => 'nullable|string|max:255',
            'exercises' => 'nullable|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|string',
            'exercises.*.order' => 'required|integer|min:0',
        ]);

        $session = Session::create([
            'week_id' => $validated['week_id'],
            'session_number' => $validated['session_number'],
            'name' => $validated['name'],
            'focus' => $validated['focus'],
        ]);

        // Ajouter les exercices
        if (isset($validated['exercises'])) {
            foreach ($validated['exercises'] as $exerciseData) {
                SessionExercise::create([
                    'session_id' => $session->id,
                    'exercise_id' => $exerciseData['exercise_id'],
                    'order' => $exerciseData['order'],
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                ]);
            }
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Séance créée avec succès !');
    }

    // Afficher une séance
    public function show(Session $session)
    {
        $session->load(['week.program', 'sessionExercises.exercise']);
        return view('admin.sessions.show', compact('session'));
    }

    // Formulaire d'édition
    public function edit(Session $session)
    {
        $session->load('sessionExercises');
        $weeks = Week::with('program')->get();
        $exercises = Exercise::orderBy('name')->get();
        
        return view('admin.sessions.edit', compact('session', 'weeks', 'exercises'));
    }

    // Mettre à jour une séance
    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'week_id' => 'required|exists:weeks,id',
            'session_number' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'focus' => 'nullable|string|max:255',
            'exercises' => 'nullable|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|string',
            'exercises.*.order' => 'required|integer|min:0',
        ]);

        $session->update([
            'week_id' => $validated['week_id'],
            'session_number' => $validated['session_number'],
            'name' => $validated['name'],
            'focus' => $validated['focus'],
        ]);

        // Supprimer les anciens exercices et en créer de nouveaux
        $session->sessionExercises()->delete();

        if (isset($validated['exercises'])) {
            foreach ($validated['exercises'] as $exerciseData) {
                SessionExercise::create([
                    'session_id' => $session->id,
                    'exercise_id' => $exerciseData['exercise_id'],
                    'order' => $exerciseData['order'],
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                ]);
            }
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Séance modifiée avec succès !');
    }

    // Supprimer une séance
    public function destroy(Session $session)
    {
        $session->delete();

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Séance supprimée avec succès !');
    }
}