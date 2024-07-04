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
        // $meetings = DB::table('meetings')
        //         ->join('timeslots', 'meetings.timeslot_id', '=', 'timeslots.timeslot_id')
        //         ->join('users','meetings.user_id','=','users.user_id')
        //         ->where('meetings.module_id', $module_id)
        //         ->get();

                $meetings = DB::table('meetings')
                ->join('timeslots', 'meetings.timeslot_id', '=', 'timeslots.timeslot_id')
                ->join('users as professor', 'meetings.user_id', '=', 'professor.user_id') // Alias for professor
                ->leftJoin('users as student', 'meetings.booked_by_user_id', '=', 'student.user_id') // Alias for student
                ->select(
                    'meetings.*', 
                    'timeslots.*', 
                    'professor.first_name as professor_first_name', // Professor's first name
                    'professor.last_name as professor_last_name', // Professor's last name
                    'student.first_name as student_first_name', // Student's first name
                    'student.last_name as student_last_name' // Student's last name
                )
                ->where('meetings.module_id', $module_id)
                ->get();

// dd($meetings);
        return view('professor.meetings.index', compact('module','meetings'));
    }

    public function indexForStudent($module_id)
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
        return view('student.meetings.index', compact('module','meetings'));
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
            'timeslot_id' => $timeslot->id,  // this one corret keeee ? 
            'status' => 'pending', // Default status
        ]);
        return redirect()->route('modules.meetings.professor.index', ['module_id' => $module_id])->with('success', 'Meeting created successfully');
    }

    public function update(Request $request, $module_id, $meeting_id)
    {
        // Assuming Meeting is your Eloquent model and is set up correctly
        $meeting = Meeting::where('meeting_id', $meeting_id)->firstOrFail();

        // $meeting->is_booked = true;  // timeslot 
        $meeting->status = $request->input('status');
        $meeting->booked_by_user_id = auth()->id();
        $meeting->save();

        $timeslot = TimeSlot::where('timeslot_id',$meeting->timeslot_id)->firstOrFail();
        $timeslot->is_booked = true; 
        // dd($timeslot);
        return redirect()->route('modules.meetings.student.index', ['module_id' => $module_id])
                        ->with('success', 'Meeting slot booked successfully!');
    }


    

}
