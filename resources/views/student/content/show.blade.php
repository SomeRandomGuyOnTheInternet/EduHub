<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    @livewire('student.sidebar', ['currentPage' => StudentSidebarLink::ModuleContent, 'currentModule' => $module_id])

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Content", 'currentModuleId' => $module_id])
        <div class="p-4">
            <div class="card">
                <div class="card-header">
                    {{ $content->title }}
                </div>
                <div class="card-body">
                    <p>{{ $content->description }}</p>
                    @if(strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) == 'PDF')
                        <div class="pdf-viewer">
                            <embed src="{{ route('modules.student.content.view', ['module_id' => $module->module_id, 'content_id' => $content->content_id]) }}" width="100%" height="1200px" type="application/pdf">
                        </div>
                    @endif
                    <p><strong>File Type:</strong> {{ strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) }}</p>
                    <p><strong>Uploaded On:</strong> {{ $content->created_at->format('h:iA, d M Y') }}</p>
                    <form action="{{ route('modules.student.content.toggle-favourite', ['module_id' => $module->module_id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="content_ids[]" value="{{ $content->content_id }}">
                        <button type="submit" class="btn btn-primary">
                            {{ $content->is_favourited ? 'Unfavourite' : 'Favourite' }}
                        </button>
                    </form>
                    @if ($content->file_path)
                        <form action="{{ route('modules.student.content.downloadSingle', ['module_id' => $module->module_id, 'content_id' => $content->content_id]) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-success">Download</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</x-layout>
