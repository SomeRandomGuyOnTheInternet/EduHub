<x-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    @livewire('professor.sidebar', ['currentPage' => ProfessorSidebarLink::ModuleAssignment, 'currentModule' => $module_id])

<div class="container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => $assignment->title, 'currentModuleId' => $module_id])
        <div class="p-4">
            <h1>{{ $assignment->title }}</h1>
            <p>{{ $assignment->description }}</p>
            <p><strong>Weightage:</strong> {{ $assignment->weightage }}</p>
            <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>
            @if($assignment->file_path)
                <p><strong>File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">{{ $fileName }}</a></p>
            @endif
        </div>
    </div>
</x-layout>
