<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\UserProgram;
use Illuminate\Http\Request;

class UserProgramController extends Controller
{
    public function index()
    {
        // Récupérer TOUS les utilisateurs (y compris l'admin)
        $users = User::with('assignedPrograms')
            ->orderBy('name')
            ->get();

        $programs = Program::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.user-programs.index', compact('users', 'programs'));
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'nullable|date',
        ]);

        // Mettre tous les programmes de l'utilisateur à is_current = false
        UserProgram::where('user_id', $validated['user_id'])
            ->update(['is_current' => false]);

        // Créer ou mettre à jour l'assignment
        UserProgram::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'program_id' => $validated['program_id'],
            ],
            [
                'start_date' => $validated['start_date'] ?? now(),
                'is_current' => true,
            ]
        );

        return redirect()->back()->with('success', 'Programme assigné avec succès !');
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        UserProgram::where('user_id', $validated['user_id'])
            ->where('program_id', $validated['program_id'])
            ->delete();

        return redirect()->back()->with('success', 'Programme retiré avec succès !');
    }
    //permettre de changer le programme actuel sans supprimer/réassigner
    public function setCurrent(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        // Mettre tous les programmes de l'utilisateur à is_current = false
        UserProgram::where('user_id', $validated['user_id'])
            ->update(['is_current' => false]);

        // Mettre le programme sélectionné à is_current = true
        UserProgram::where('user_id', $validated['user_id'])
            ->where('program_id', $validated['program_id'])
            ->update(['is_current' => true]);

        return redirect()->back()->with('success', 'Programme actuel mis à jour !');
    }
}