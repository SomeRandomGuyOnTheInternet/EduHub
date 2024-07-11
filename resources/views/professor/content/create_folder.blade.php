<x-app-layout>
    <x-slot name="title">
        {{ __('Create Folder') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Folder for Module: ') }}{{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('modules.professor.folder.store', ['module_id' => $module->module_id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="folder_name">Folder Name</label>
                <input type="text" class="form-control" id="folder_name" name="folder_name" required>
            </div>
            <button type="submit" class="btn btn-success">Create Folder</button>
        </form>
    </div>
</x-app-layout>
