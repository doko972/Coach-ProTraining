<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Si l'utilisateur est connecté, rediriger vers le carnet
        if (auth()->check()) {
            return redirect()->route('workout.index');
        }
        
        // Sinon afficher la page d'accueil
        return view('welcome');
    }
}