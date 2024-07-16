<x-app-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1>{{ $assignment->title }}</h1>
        <p>{{ $assignment->description }}</p>
        <p><strong>Weightage:</strong> {{ $assignment->weightage }}</p>
        <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>
        @if($assignment->file_path)
            <p><strong>File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">{{ $fileName }}</a></p>
        @endif

        <h2>Student Submissions</h2>
        @if($submissions->isEmpty())
            <p>No submissions found.</p>
        @else
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Description</th>
                        <th>Files</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $submission)
                        <tr>
                            <td>{{ $submission->user->name }}</td>
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
