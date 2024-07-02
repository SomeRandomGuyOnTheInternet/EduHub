@extends('layouts.app')

@section('content')
    <h1>Timeslots</h1>
    <a href="{{ route('timeslots.create') }}">Add Timeslot</a>
    <ul>
        @foreach ($timeslots as $timeslot)
            <li>{{ $timeslot->meeting_date }} {{ $timeslot->timeslot }} - {{ $timeslot->is_booked ? 'Booked' : 'Available' }}</li>
        @endforeach
    </ul>
@endsection