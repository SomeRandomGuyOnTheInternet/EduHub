<x-app-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    @livewire('student.sidebar', ['currentPage' => StudentSidebarLink::ModuleAssignment, 'currentModule' => $module_id])
    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => $assignment->title, 'currentModuleId' => $module_id])
        <div class="p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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

        {{-- {{route('modules.student.assignment.submit')}} --}}
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
    </div>
</x-app-layout>
