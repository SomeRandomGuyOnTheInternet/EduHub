<x-layout>
    <x-slot name="title">
        {{ __('Meetings') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleMeetings :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Meetings", 'currentModuleId' => $module_id])
        <div class="p-4">
            <a href="{{ route('modules.professor.meetings.create', ['module_id' => $module->module_id]) }}"
                class="btn btn-primary mb-3">Create Meeting Slot</a>
            <div class="row">
                @forelse ($meetings as $meeting)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                Meeting Date: {{ $meeting->meeting_date }}
                                <br>
                                Meeting Time: {{ $meeting->timeslot }}
                                <br>
                                Meeting held by : Prof {{$meeting->professor_first_name }} {{ $meeting->professor_last_name }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">Status: <strong>{{ $meeting->status }}</strong></p>

                                @if($meeting->status == 'pending' && auth()->user()->id == $meeting->user_id)
                                    <form
                                        action="{{ route('modules.professor.meetings.update', [$module->module_id, $meeting->meeting_id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="btn btn-success">Accept</button>
                                    </form>
                                    <form
                                        action="{{ route('modules.professor.meetings.update', [$module->module_id, $meeting->meeting_id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                @endif  
                                <p class="card-text">Student: <strong>{{  $meeting->student_first_name }}
                                        {{  $meeting->student_last_name }}</strong></p>

                                <a href="{{ route('modules.professor.meetings.edit', [$module->module_id, $meeting->meeting_id]) }}"
                                    class="btn btn-warning">Edit</a>
                                <form
                                    action="{{ route('modules.professor.meetings.destroy', [$module->module_id, $meeting->meeting_id]) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this meeting?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="p-3">No meeting slots created.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>