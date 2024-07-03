<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function index($module_id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        // $meetings = Meeting::with('user', 'timeslot.user')->get();
        $meetings = DB::table('meetings')
                ->join('timeslots', 'meetings.timeslot_id', '=', 'timeslots.timeslot_id')
                ->join('users','meetings.user_id','=','users.user_id')
                ->where('meetings.module_id', $module_id)
                ->get();
        // DB::table('modules')
        //         ->join('teaches', 'modules.module_id', '=', 'teaches.module_id')
        //         ->where('teaches.user_id', $userId)
        //         ->select('modules.module_name', 'modules.module_id') // Include module_id in the selection
        //         ->get();
        // $timeslots = DB::table('timeslots');
        // dd($meetings);
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

        $validatedData = $request->validate([
            'meeting_date' => 'required|date',  // Ensuring that a valid date is provided for the meeting
            'time' => 'required|in:09:00,10:00,11:00,12:00,13:00,14:00,15:00,17:00',  // Ensuring the time is within the specified valid times
        ]);

        // First, create or find the timeslot for the given time and date
        $timeslot = Timeslot::firstOrCreate([
            'meeting_date' => $request->meeting_date,
            'timeslot' => $request->time,
            'user_id' => auth()->id(), // Assuming the authenticated user is creating this
        ], [
            'is_booked' => false, // Set the timeslot as not booked yet
        ]);

        // Create a new meeting using the timeslot and module information
        $newMeeting = Meeting::create([
            'user_id' => auth()->id(),
            'module_id' => $module_id,
            'timeslot_id' => $timeslot->id,
            'status' => 'pending', // Default status
        ]);
        return redirect()->route('modules.meetings.professor.index', ['module_id' => $module_id])->with('success', 'Meeting created successfully');
    }

    public function update(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $meeting->status = $request->status;
        $meeting->save();
        return redirect()->route('meetings.index');
    }
}
