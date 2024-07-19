<x-layouts>
    <x-slot name="title">
        Dashboard
    </x-slot>

    @livewire('professor.sidebar', ['currentPage' => ProfessorSidebarLink::ModuleHome])
    <div class="container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Home", 'currentModuleId' => $module_id])
        <div class="p-4">
            
        </div>
    </div>
</x-layouts>
