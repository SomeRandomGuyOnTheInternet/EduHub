<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'timeslot_id', 'status'];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }
}
