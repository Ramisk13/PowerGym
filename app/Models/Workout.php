<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'duration',
    ];

    public function trainerAssignments()
    {
        return $this->hasMany(TrainerAssignment::class, 'workout_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'workout_id');
    }
}
