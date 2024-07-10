<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StudentMeetingController extends Controller
{

    public function index($module_id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        // $meetings = Meeting::with('user', 'timeslot.user')->get();
        $meetings = DB::table('meetings')
            ->join('timeslots', 'meetings.timeslot_id', '=', 'timeslots.timeslot_id')
            ->join('users', 'meetings.user_id', '=', 'users.user_id')
            ->where('meetings.module_id', $module_id)
            ->get();
        // DB::table('modules')
        //         ->join('teaches', 'modules.module_id', '=', 'teaches.module_id')
        //         ->where('teaches.user_id', $userId)
        //         ->select('modules.module_name', 'modules.module_id') // Include module_id in the selection
        //         ->get();
        // $timeslots = DB::table('timeslots');
        // dd($meetings);
        return view('student.meetings.index', compact('module', 'meetings'));
    }

    public function update(Request $request, $module_id, $meeting_id)
    {
        // Assuming Meeting is your Eloquent model and is set up correctly
        $meeting = Meeting::where('meeting_id', $meeting_id)->firstOrFail();

        // $meeting->is_booked = true;  // timeslot 
        $meeting->status = $request->input('status');
        $meeting->booked_by_user_id = auth()->id();
        $meeting->save();

        $timeslot = TimeSlot::where('timeslot_id', $meeting->timeslot_id)->firstOrFail();
        $timeslot->is_booked = true;
        // dd($timeslot);
        return redirect()->route('modules.student.meetings.index', ['module_id' => $module_id])
            ->with('success', 'Meeting slot booked successfully!');
    }




}
