<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Models\Module;

class MeetingController extends Controller
{
    public function index($module_id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        $meetings = Meeting::with('user', 'timeslot.user')->get();
        return view('professor.meetings.index', compact('module','meetings'));
    }

    public function create($module_id)
    {
        $timeslots = Timeslot::where('is_booked', false)->get();
        $times = ['09:00', '10:00','11:00', '12:00','13:00', '14:00','15:00', '17:00'];
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        // dd($module);
        return view('professor.meetings.create', compact('timeslots','times','module_id','module'));
    }

    public function store(Request $request, $module_id)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'timeslot_id' => 'required|exists:timeslots,id',
            'meeting_date' => 'required|date',
            'time' => 'required|in:09:00,10:00,11:00,12:00,13:00,14:00,15:00,17:00',

        ]);

        dd($module);
        $timeslot = Timeslot::find($request->timeslot_id);
        $timeslot->is_booked = false;
        $timeslot->save();

        $newMeeting = Meeting::create($request->all());
        return redirect()->route('modules.meetings.professor.index')->with('success','meeting created successfully');
    }

    public function update(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->status = $request->status;
        $meeting->save();
        return redirect()->route('meetings.index');
    }
}
