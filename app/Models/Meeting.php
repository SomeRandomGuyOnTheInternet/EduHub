<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'timeslot_id', 'module_id', 'meeting_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
