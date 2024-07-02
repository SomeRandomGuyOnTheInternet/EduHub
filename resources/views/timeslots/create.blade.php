@extends('layouts.app')

@section('content')
    <h1>Create Timeslot</h1>
    <form action="{{ route('timeslots.store') }}" method="POST">
        @csrf
        <label for="professor_id">Professor ID:</label>
        <input type="number" name="professor_id" id="professor_id" required>
        <label for="meeting_date">Meeting Date:</label>
        <input type="date" name="meeting_date" id="meeting_date" required>
        <label for="timeslot">Timeslot:</label>
        <select name="timeslot" id="timeslot" required>
            <option value="09:00">09:00</option>
            <option value="11:00">11:00</option>
            <option value="13:00">13:00</option>
            <option value="15:00">15:00</option>
            <option value="17:00">17:00</option>
        </select>
        <button type="submit">Create</button>
    </form>
@endsection
