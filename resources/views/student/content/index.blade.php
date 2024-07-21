<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    @livewire('student.sidebar', ['currentPage' => StudentSidebarLink::ModuleContent, 'currentModule' => $module_id])

    <div class="container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => 'Content', 'currentModuleId' => $module_id])
        <div class="p-4">
            @livewire('student.content-table', ['module_id' => $module_id])
        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($folders as $folder)
                document.getElementById('select-all-{{ $folder->module_folder_id }}').addEventListener('change', function () {
                    const checkboxes = document.querySelectorAll('.content-checkbox-{{ $folder->module_folder_id }}');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                document.querySelector('.download-content-ids').value = Array.from(document.querySelectorAll('.content-checkbox-{{ $folder->module_folder_id }}:checked')).map(cb => cb.value).join(',');
            @endforeach
        });
    </script> --}}
</x-layout>
