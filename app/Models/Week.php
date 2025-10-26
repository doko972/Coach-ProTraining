<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'week_number',
        'name'
    ];

    // Relations
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}