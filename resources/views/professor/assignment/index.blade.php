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
        <a href="{{ route('modules.professor.assignments.create', $module_id) }}" class="btn btn-primary">Create Assignment</a>
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
                            <a href="{{ route('modules.professor.assignments.show', [$module_id, $assignment->assignment_id]) }}" class="btn btn-info">View</a>
                            <a href="{{ route('modules.professor.assignments.edit', [$module_id, $assignment->assignment_id]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('modules.professor.assignments.destroy', [$module_id, $assignment->assignment_id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
