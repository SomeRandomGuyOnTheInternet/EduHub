@extends('layouts.app')

@section('content')
    <h1>Book Meeting</h1>
    <form action="{{ route('meetings.store') }}" method="POST">
        @csrf
        <label for="student_id">Student ID:</label>
        <input type="number" name="student_id" id="student_id" required>
        <label for="timeslot_id">Timeslot:</label>
        <select name="timeslot_id" id="timeslot_id" required>
            @foreach ($timeslots as $timeslot)
                <option value="{{ $timeslot->id }}">{{ $timeslot->meeting_date }} {{ $timeslot->timeslot }}</option>
            @endforeach
        </select>
        <button type="submit">Book</button>
    </form>
@endsection
