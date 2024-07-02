@extends('layouts.app')

@section('title', 'Create Content')

@section('content')
<div class="container mt-5">
    <h2>Create Content for Module: {{ $module->module_name }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('modules.content.professor.store-content', ['module_id' => $module->module_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="module_folder_id">Folder</label>
            <select class="form-control" id="module_folder_id" name="module_folder_id" required>
                @foreach ($folders as $folder)
                    <option value="{{ $folder->module_folder_id }}">{{ $folder->folder_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Content Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="file_path">Upload File</label>
            <input type="file" class="form-control-file" id="file_path" name="file_path">
        </div>
        <button type="submit" class="btn btn-success">Create Content</button>
    </form>
</div>
@endsection
