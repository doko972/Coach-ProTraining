<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_exercise_id',
        'set_number',
        'weight',
        'reps',
        'completed',
        'workout_date'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'workout_date' => 'date',
        'weight' => 'decimal:2'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sessionExercise()
    {
        return $this->belongsTo(SessionExercise::class);
    }
}