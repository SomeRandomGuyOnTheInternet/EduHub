@extends('layouts.app')
@section('content')
    <h1>Create Meeting Slot for Module: {{ $module->module_name}} </h1>
    
    <form action="{{ route('modules.meetings.professor.store', ['module_id' => $module->module_id]) }}" method="POST">
        @csrf
        @method('post')
        <label for="meeting_date">Meeting Date:</label>
        <input type="date" name="meeting_date" id="meeting_date" required>
        <label for="times">Time:</label>
        <select name="time" id="times" required>
            @foreach ($times as $time)
            <option value="{{ $time }}">{{ $time }}</option>
            @endforeach
        </select>
        
        <button type="submit">Create Timeslot</button>
        <br> 
        <a href="{{ route('modules.meetings.professor.index', ['module_id' => $module->module_id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
