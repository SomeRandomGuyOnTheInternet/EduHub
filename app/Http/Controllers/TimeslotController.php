<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Models\Module;

class TimeslotController extends Controller
{
    public function index()
    {
        $timeslots = Timeslot::all();
        return view('timeslots.index', compact('timeslots'));
    }

    public function create()
    {
        return view('timeslots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'meeting_date' => 'required|date',
            'timeslot' => 'required|in:09:00,11:00,13:00,15:00,17:00',
        ]);

        Timeslot::create($request->all());
        return redirect()->route('timeslots.index');
    }
}
