<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'workout_id',
        'attended_at',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
