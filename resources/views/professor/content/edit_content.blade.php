@extends('layouts.app')

@section('title', 'Learning Content')

@section('content')

<body>
    <div class="container mt-5">
        <h2>Edit Content for Module: {{ $module->module_name }}</h2>
        <form
            action="{{ route('modules.professor.content.update', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="module_folder_id">Folder</label>
                <select class="form-control" id="module_folder_id" name="module_folder_id" required>
                    @foreach ($folders as $folder)
                    <option value="{{ $folder->module_folder_id }}"
                        {{ $folder->module_folder_id == $content->module_folder_id ? 'selected' : '' }}>
                        {{ $folder->folder_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="title">Content Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $content->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description"
                    name="description">{{ $content->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="file_path">Upload New File (Optional)</label>
                <input type="file" class="form-control-file" id="file_path" name="file_path">
            </div>
            <button type="submit" class="btn btn-success">Update Content</button>
        </form>
    </div>
</body>

@endsection