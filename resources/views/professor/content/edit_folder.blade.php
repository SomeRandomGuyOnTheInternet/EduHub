<x-layouts>
    <x-slot name="title">
        {{ __('Edit Folder') }}
    </x-slot>

    @livewire('professor.sidebar', ['currentPage' => ProfessorSidebarLink::ModuleContent, 'currentModule' => $module_id])

    <div class="container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Edit Folder", 'currentModuleId' => $module_id])
        <form action="{{ route('modules.professor.folder.update', ['module_id' => $module->module_id, 'folder' => $folder->module_folder_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="folder_name">Folder Name</label>
                <input type="text" class="form-control" id="folder_name" name="folder_name" value="{{ $folder->folder_name }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update Folder</button>
        </form>
    </div>
</x-layouts>
