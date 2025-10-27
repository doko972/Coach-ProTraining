<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Week;
use App\Models\Program;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function create(Request $request)
    {
        $programId = $request->get('program_id');
        $program = Program::findOrFail($programId);
        
        return view('admin.weeks.create', compact('program'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'week_number' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ]);

        Week::create($validated);

        return redirect()->route('admin.programs.edit', $validated['program_id'])
            ->with('success', 'Semaine créée avec succès !');
    }

    public function edit(Week $week)
    {
        return view('admin.weeks.edit', compact('week'));
    }

    public function update(Request $request, Week $week)
    {
        $validated = $request->validate([
            'week_number' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ]);

        $week->update($validated);

        return redirect()->route('admin.programs.edit', $week->program_id)
            ->with('success', 'Semaine modifiée avec succès !');
    }

    public function destroy(Week $week)
    {
        $programId = $week->program_id;
        $week->delete();

        return redirect()->route('admin.programs.edit', $programId)
            ->with('success', 'Semaine supprimée avec succès !');
    }
}