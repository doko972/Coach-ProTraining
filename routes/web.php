<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin (protégées par authentification)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Gestion des programmes
    Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);

    // Gestion des exercices
    Route::resource('exercises', App\Http\Controllers\Admin\ExerciseController::class);

    // Gestion des séances
    Route::resource('sessions', App\Http\Controllers\Admin\SessionController::class);

    // Routes pour les semaines
    Route::get('/weeks/create', [App\Http\Controllers\Admin\WeekController::class, 'create'])->name('weeks.create');
    Route::post('/weeks', [App\Http\Controllers\Admin\WeekController::class, 'store'])->name('weeks.store');
    Route::get('/weeks/{week}/edit', [App\Http\Controllers\Admin\WeekController::class, 'edit'])->name('weeks.edit');
    Route::put('/weeks/{week}', [App\Http\Controllers\Admin\WeekController::class, 'update'])->name('weeks.update');
    Route::delete('/weeks/{week}', [App\Http\Controllers\Admin\WeekController::class, 'destroy'])->name('weeks.destroy');
});
// Routes Utilisateur (protégées par authentification)
Route::middleware('auth')->group(function () {

    // Carnet d'entraînement
    Route::get('/carnet', [App\Http\Controllers\User\WorkoutController::class, 'index'])
        ->name('workout.index');

    // Chronomètre
    Route::get('/chrono', [App\Http\Controllers\User\WorkoutController::class, 'chrono'])
        ->name('workout.chrono');

    // Calcul 1RM
    Route::get('/calc1rm', [App\Http\Controllers\User\WorkoutController::class, 'calc1rm'])
        ->name('workout.calc1rm');

    // API pour sauvegarder
    Route::post('/workout/save', [App\Http\Controllers\User\WorkoutController::class, 'saveWorkout'])
        ->name('workout.save');

    Route::post('/workout/notes', [App\Http\Controllers\User\WorkoutController::class, 'saveNotes'])
        ->name('workout.notes');

    Route::get('/workout/data', [App\Http\Controllers\User\WorkoutController::class, 'getWorkoutData'])
        ->name('workout.data');
});

require __DIR__ . '/auth.php';
