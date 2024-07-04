<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $primaryKey = 'meeting_id';
    protected $fillable = ['user_id', 'timeslot_id', 'module_id', 'meeting_time', 'booked_by_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeslot()
    {
        // return $this->belongsTo(Timeslot::class);
        return $this->belongsTo(Timeslot::class, 'timeslot_id');

    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
