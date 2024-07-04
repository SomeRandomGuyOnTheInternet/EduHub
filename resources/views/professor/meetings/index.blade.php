@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-3">Meetings for {{ $module->module_name }} </h1>
        <a href="{{ route('modules.meetings.professor.create', ['module_id' => $module->module_id]) }}" class="btn btn-primary mb-3">Create Meeting Slot</a>
        <div class="row">
            @foreach ($meetings as $meeting)
                <div class="col-md-4 mb-4">
                    <div class="card">
                  
                        <div class="card-header">
                            Meeting Date: {{ $meeting->meeting_date }} 
                            <br>
                            Meeting Time: {{ $meeting->timeslot }}
                            <br>
                            Meeting held by : Prof {{$meeting->first_name }} {{ $meeting->last_name }}
                        </div>
                        <div class="card-body">
                            <p class="card-text">Status: <strong>{{ $meeting->status }}</strong></p>

                            @if($meeting->status == 'pending' && auth()->user()->id == $meeting->user_id)
                
                                <form action="{{ route('meetings.update', $meeting->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form action="{{ route('meetings.update', $meeting->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @endif

                            <p class="card-text">Status: <strong>{{ $meeting->status }}</strong></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
