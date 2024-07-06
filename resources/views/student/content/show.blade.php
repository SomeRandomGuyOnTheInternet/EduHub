@extends('layouts.app')

@section('title', 'Learning Content')

@section('content')
<body>
    <div class="container mt-5">
        <h2>{{ $module->module_name }} - Content Details</h2>
        <div class="card">
            <div class="card-header">
                {{ $content->title }}
            </div>
            <div class="card-body">
                <p>{{ $content->description }}</p>
                @if(strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) == 'PDF')
                <div class="pdf-viewer">
                    <embed src="{{ route('modules.content.student.view', ['module_id' => $module->module_id, 'content_id' => $content->content_id]) }}" width="100%" height="1200px" type="application/pdf">
                </div>
                @endif
                <p><strong>File Type:</strong> {{ strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) }}</p>
                <p><strong>Uploaded On:</strong> {{ $content->created_at->format('h:iA, d M Y') }}</p>
                <form action="{{ route('modules.content.student.toggle-favourite', ['module_id' => $module->module_id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="content_ids[]" value="{{ $content->content_id }}">
                    <button type="submit" class="btn btn-primary">
                        {{ $content->is_favourited ? 'Unfavourite' : 'Favourite' }}
                    </button>
                </form>
                <form action="{{ route('modules.content.student.downloadSingle', ['module_id' => $module->module_id, 'content_id' => $content->content_id]) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-success">Download</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
