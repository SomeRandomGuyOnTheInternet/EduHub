<x-app-layout>
    <x-slot name="title">
        {{ __('Assignments') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleAssignment :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Assignments", 'currentModuleId' => $module_id])
        <div class="p-4">
            <livewire:student.assignment-table :module_id=$module_id lazy>
        </div>
    </div>
</x-app-layout>

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