<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        if (!auth()->user()->is_admin) {
            return redirect()->route('workout.index')->with('error', 'Accès non autorisé. Vous n\'êtes pas administrateur.');
        }

        return $next($request);
    }
}