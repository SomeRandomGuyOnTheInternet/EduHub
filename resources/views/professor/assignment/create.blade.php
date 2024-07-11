<x-app-layout>
    <x-slot name="title">
        {{ __('Create Assignment') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Assignment') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1>Create Assignment</h1>
        <form action="{{ route('modules.professor.assignments.store', $module_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="weightage">Weightage</label>
                <input type="number" class="form-control" id="weightage" name="weightage" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</x-app-layout>
