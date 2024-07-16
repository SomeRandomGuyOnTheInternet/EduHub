<x-app-layout>
    <x-slot name="title">
        {{ __('Assignment Submissions') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assignment Submissions') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1>{{ $assignment->title }}</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Description</th>
                    <th>Submission Date</th>
                    <th>Files</th>
                    <th>Grade</th>
                    <th>Feedback</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                    <tr>
                        <td>{{ $submission->user->name }}</td>
                        <td>{{ $submission->submission_description }}</td>
                        <td>{{ $submission->submission_date }}</td>
                        <td>
                            @foreach ($submission->submission_files as $file)
                                <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a><br>
                            @endforeach
                        </td>
                        <td>{{ $submission->grade }}</td>
                        <td>{{ $submission->feedback }}</td>
                        <td>
                            <form action="{{ route('modules.professor.assignments.grade', [$module_id, $assignment->assignment_id, $submission->assignment_submission_id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="grade">Grade</label>
                                    <input type="number" name="grade" id="grade" class="form-control" required min="0" max="100" value="{{ $submission->grade }}">
                                </div>
                                <div class="form-group">
                                    <label for="feedback">Feedback</label>
                                    <textarea name="feedback" id="feedback" rows="2" class="form-control">{{ $submission->feedback }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
