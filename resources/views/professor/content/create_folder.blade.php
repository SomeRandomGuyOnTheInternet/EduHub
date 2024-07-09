@extends('layouts.app')

@section('title', 'Create Folder')

@section('content')
<div class="container mt-5">
    <h2>Create Folder for Module: {{ $module->module_name }}</h2>
    <form action="{{ route('modules.professor.folder.store', ['module_id' => $module->module_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="folder_name">Folder Name</label>
            <input type="text" class="form-control" id="folder_name" name="folder_name" required>
        </div>
        <button type="submit" class="btn btn-success">Create Folder</button>
    </form>
</div>
@endsection
