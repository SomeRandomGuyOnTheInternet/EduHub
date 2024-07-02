<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'meeting_date', 'timeslot', 'is_booked'];

    public function professor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
