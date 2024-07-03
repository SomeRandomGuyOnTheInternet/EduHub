@extends('layouts.app')

@section('content')
    <h1>Meetings</h1>
    <a href="{{ route('meetings.create') }}">Book Meeting</a>
    <ul>
        @foreach ($meetings as $meeting)
            <li>
                Student: {{ $meeting->student->name }},
                Professor: {{ $meeting->timeslot->professor->name }},
                Time: {{ $meeting->timeslot->meeting_date }} {{ $meeting->timeslot->timeslot }},
                Status: {{ $meeting->status }}
                @if($meeting->status == 'pending' && auth()->user()->id == $meeting->timeslot->professor_id)
                    <form action="{{ route('meetings.update', $meeting->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit">Accept</button>
                    </form>
                    <form action="{{ route('meetings.update', $meeting->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit">Reject</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
@endsection
