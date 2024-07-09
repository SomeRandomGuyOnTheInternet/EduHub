@extends('layouts.app')

@section('title', 'Learning Content')

@section('content')

<body>
    <div class="container mt-5">
        <h2>Edit Folder for Module: {{ $module->module_name }}</h2>
        <form
            action="{{ route('modules.professor.folder.update', ['module_id' => $module->module_id, 'folder_id' => $folder->module_folder_id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="folder_name">Folder Name</label>
                <input type="text" class="form-control" id="folder_name" name="folder_name"
                    value="{{ $folder->folder_name }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update Folder</button>
        </form>
    </div>
</body>

@endsection