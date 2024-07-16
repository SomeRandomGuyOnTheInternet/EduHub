<x-app-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assignment Details') }}
        </h2>
    </x-slot>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <div class="container mt-5">
        <h1>{{ $assignment->title }}</h1>
        <p>{{ $assignment->description }}</p>
        <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2>Submit Your Work</h2>
        <form action="{{ route('modules.student.assignments.submit', [$module_id, $assignment->assignment_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="files">Upload Files</label>
                <input type="file" name="files[]" id="files" class="form-control" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-app-layout>
