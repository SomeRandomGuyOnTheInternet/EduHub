<x-app-layout>
    <x-slot name="title">
        {{ __('Assignments') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assignments') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1>Assignments</h1>
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
                            <a href="{{ route('modules.student.assignments.show', [$module_id, $assignment->assignment_id]) }}" class="btn btn-info">View</a>
                            <a href="{{ route('modules.student.assignments.download', [$module_id, $assignment->assignment_id]) }}" class="btn btn-success">Download Brief</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>My Submissions</h2>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
