<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_id',
        'session_number',
        'name',
        'focus'
    ];

    // Relations
    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function sessionExercises()
    {
        return $this->hasMany(SessionExercise::class)->orderBy('order');
    }

    public function userNotes()
    {
        return $this->hasMany(UserNote::class);
    }
}