<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\UserWorkout;
use App\Models\UserNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    // Page du carnet d'entraînement
    public function index(Request $request)
    {
        $user = auth()->user();

        // Récupérer uniquement les programmes assignés à cet utilisateur
        $programs = $user->assignedPrograms()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Si l'utilisateur n'a aucun programme assigné
        if ($programs->isEmpty()) {
            return view('user.workout.index', [
                'program' => null,
                'programs' => collect([]),
                'message' => 'Aucun programme ne vous a été assigné. Contactez votre coach.'
            ]);
        }

        // Récupérer le programme sélectionné
        $selectedProgramId = $request->get('program_id')
            ?? session('selected_program_id')
            ?? $user->currentProgram()?->id
            ?? $programs->first()->id;

        // Sauvegarder le choix en session
        session(['selected_program_id' => $selectedProgramId]);

        // Charger le programme avec toutes ses relations
        $program = Program::with([
            'weeks' => function ($query) {
                $query->orderBy('week_number');
            },
            'weeks.sessions' => function ($query) {
                $query->orderBy('session_number');
            },
            'weeks.sessions.sessionExercises' => function ($query) {
                $query->orderBy('order');
            },
            'weeks.sessions.sessionExercises.exercise'
        ])->findOrFail($selectedProgramId);

        return view('user.workout.index', compact('program', 'programs'));
    }

    // Page chronomètre
    public function chrono()
    {
        return view('user.workout.chrono');
    }

    // Page calcul 1RM
    public function calc1rm()
    {
        return view('user.workout.calc1rm');
    }

    // Sauvegarder les données d'entraînement
    public function saveWorkout(Request $request)
    {
        $validated = $request->validate([
            'session_exercise_id' => 'required|exists:session_exercises,id',
            'set_number' => 'required|integer',
            'weight' => 'nullable|numeric',
            'reps' => 'nullable|integer',
            'completed' => 'boolean',
            'workout_date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();

        UserWorkout::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'session_exercise_id' => $validated['session_exercise_id'],
                'set_number' => $validated['set_number'],
                'workout_date' => $validated['workout_date'],
            ],
            $validated
        );

        return response()->json(['success' => true]);
    }

    // Sauvegarder les notes
    public function saveNotes(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'notes' => 'required|string',
            'workout_date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();

        UserNote::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'session_id' => $validated['session_id'],
                'workout_date' => $validated['workout_date'],
            ],
            $validated
        );

        return response()->json(['success' => true]);
    }

    // Récupérer les données d'entraînement
    public function getWorkoutData(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $workouts = UserWorkout::where('user_id', Auth::id())
            ->where('workout_date', $date)
            ->get();

        return response()->json($workouts);
    }
}
