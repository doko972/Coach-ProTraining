<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Exercise;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'programs' => Program::count(),
            'exercises' => Exercise::count(),
            'sessions' => Session::count(),
            'users' => User::count(),
        ];

        $recentPrograms = Program::latest()->take(5)->get();
        $recentExercises = Exercise::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPrograms', 'recentExercises'));
    }
}