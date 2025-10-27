<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phase',
        'objective',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function weeks()
    {
        return $this->hasMany(Week::class);
    }
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'user_programs')
            ->withPivot('start_date', 'end_date', 'is_current')
            ->withTimestamps();
    }
}