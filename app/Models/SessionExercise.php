<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'exercise_id',
        'order',
        'sets',
        'reps',
        'notes'
    ];

    // Relations
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function userWorkouts()
    {
        return $this->hasMany(UserWorkout::class);
    }
}