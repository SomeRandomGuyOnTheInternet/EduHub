<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Timeslot;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with('user', 'timeslot.user')->get();
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $timeslots = Timeslot::where('is_booked', false)->get();
        return view('meetings.create', compact('timeslots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'timeslot_id' => 'required|exists:timeslots,id',
        ]);

        $timeslot = Timeslot::find($request->timeslot_id);
        $timeslot->is_booked = true;
        $timeslot->save();

        Meeting::create($request->all());
        return redirect()->route('meetings.index');
    }

    public function update(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->status = $request->status;
        $meeting->save();
        return redirect()->route('meetings.index');
    }
}
