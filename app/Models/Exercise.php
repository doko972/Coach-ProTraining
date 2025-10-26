<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'difficulty'
    ];

    // Relations
    public function sessionExercises()
    {
        return $this->hasMany(SessionExercise::class);
    }
}