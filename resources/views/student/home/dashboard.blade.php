<x-layouts>
    <x-slot name="title">
        Dashboard
    </x-slot>

    @livewire('student.sidebar', ['currentPage' => StudentSidebarLink::ModuleHome, 'currentModule' => $module_id])

    <div class="container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Home", 'currentModuleId' => $module_id])
        <div class="p-4">
        </div>
    </div>
</x-layouts>
