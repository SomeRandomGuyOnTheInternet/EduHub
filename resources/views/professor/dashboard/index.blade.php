<x-layouts>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    @livewire('professor.sidebar', ['currentPage' => ProfessorSidebarLink::Dashboard])

    <div class="container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Dashboard"])
        <div class="p4">

        </div>
    </div>
</x-layouts>