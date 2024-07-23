<x-app-layout>
    <x-slot name="title">
        {{ __('Assignments') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleAssignment :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Assignments", 'currentModuleId' => $module_id])
        <div class="p-4">
            <ul class="nav nav-pills gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;" id="dashboard-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-5" id="pills-pending-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-pending" type="button" role="tab" aria-controls="pills-pending"
                        aria-selected="false">Pending</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-5" id="pills-submitted-tab" data-bs-toggle="pill" data-bs-target="#pills-submitted"
                        type="button" role="tab" aria-controls="pills-submitted" aria-selected="true">Submitted</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab"
                    tabindex="0">
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Weightage</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->weightage }}</td>
                                    <td>{{ $assignment->due_date }}</td>
                                    <td>
                                        @php
                                            $isPastDue = \Carbon\Carbon::parse($assignment->due_date)->isPast();
                                        @endphp
                                        <a href="{{ route('modules.student.assignments.show', [$module_id, $assignment->assignment_id]) }}" class="btn btn-info {{ $isPastDue ? 'disabled' : '' }}">Submit</a>
                                        @if ($assignment->file_path)
                                            <a href="{{ route('modules.student.assignments.download', [$module_id, $assignment->assignment_id]) }}" class="btn btn-success">Download Brief</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-submitted" role="tabpanel" aria-labelledby="pills-submitted-tab"
                    tabindex="0">
                    @if($submissions->isEmpty())
                        <p>No submissions found.</p>
                    @else
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Assignment</th>
                                <th>Description</th>
                                <th>Files</th>
                                <th>Submission Date</th>
                                <th>Grade</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->assignment->title }}</td>
                                    <td>{{ $submission->submission_description }}</td>
                                    <td>
                                        @foreach (json_decode($submission->submission_files) as $file)
                                            <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a><br>
                                        @endforeach
                                    </td>
                                    <td>{{ $submission->submission_date }}</td>
                                    <td>{{ $submission->grade }}</td>
                                    <td>{{ $submission->feedback }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
