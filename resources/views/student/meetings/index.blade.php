<x-app-layout>
    <x-slot name="title">
        {{ __('Meetings') }}
    </x-slot>

    <x-slot name="header">
        <h1 class="mb-3">{{ __('Meetings for ') }}{{ $module->module_name }}</h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            @foreach ($meetings as $meeting)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Meeting Date: {{ $meeting->meeting_date }} 
                            <br>
                            Meeting Time: {{ $meeting->timeslot }}
                            <br>
                            Meeting held by : Prof {{ $meeting->first_name }} {{ $meeting->last_name }}
                        </div>
                        <div class="card-body">
                            <p class="card-text">Status: <strong>{{ $meeting->status }}</strong></p>

                            @if($meeting->status == 'vacant')                            
                                <form action="{{ route('modules.student.meetings.update', ['module_id' => $module->module_id, 'meeting' => $meeting->meeting_id])}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="booked">
                                    <input type="hidden" name="is_booked" value="true">
                                    <button type="submit" class="btn btn-success">Book this slot</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
