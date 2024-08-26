<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'workout_id',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
