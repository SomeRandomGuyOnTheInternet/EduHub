<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Folder') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Folder for Module: ') }}{{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="container mt-5">
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
</x-app-layout>
