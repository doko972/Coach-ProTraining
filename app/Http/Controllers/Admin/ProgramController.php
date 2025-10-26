<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Liste des programmes
    public function index()
    {
        $programs = Program::withCount('weeks')->latest()->paginate(10);
        return view('admin.programs.index', compact('programs'));
    }

    // Formulaire de création
    public function create()
    {
        return view('admin.programs.create');
    }

    // Enregistrer un nouveau programme
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phase' => 'nullable|string|max:255',
            'objective' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Program::create($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Programme créé avec succès !');
    }

    // Afficher un programme
    public function show(Program $program)
    {
        $program->load('weeks.sessions.sessionExercises.exercise');
        return view('admin.programs.show', compact('program'));
    }

    // Formulaire d'édition
    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    // Mettre à jour un programme
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phase' => 'nullable|string|max:255',
            'objective' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $program->update($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Programme modifié avec succès !');
    }

    // Supprimer un programme
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Programme supprimé avec succès !');
    }
}