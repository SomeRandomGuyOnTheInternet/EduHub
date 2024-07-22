<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    @livewire('professor.sidebar', ['currentPage' => ProfessorSidebarLink::ModuleContent, 'currentModule' => $module_id])

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Content", 'currentModuleId' => $module_id])
        <div class="p-4">
            <ul class="nav nav-pills gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;" id="content-tab" role="tablist">
                @foreach ($folders as $index => $folder)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link rounded-5 @if($index == 0) active @endif" id="tab-{{ $folder->module_folder_id }}"
                            data-toggle="tab" href="#folder-{{ $folder->module_folder_id }}" role="tab"
                            aria-controls="folder-{{ $folder->module_folder_id }}"
                            aria-selected="true">{{ $folder->folder_name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="contentTabsContent">
                @foreach ($folders as $index => $folder)
                    <div class="tab-pane fade @if($index == 0) show active @endif" id="folder-{{ $folder->module_folder_id }}"
                        role="tabpanel" aria-labelledby="tab-{{ $folder->module_folder_id }}">
                        <div class="mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Time Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($folder->contents as $content)
                                        <tr>
                                            <td><a
                                                    href="{{ route('modules.professor.content.show', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}">{{ $content->title }}</a>
                                            </td>
                                            <td>{{ strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) }}</td>
                                            <td>{{ $content->created_at->format('h:iA, d M') }}</td>
                                            <td>
                                                <a href="{{ route('modules.professor.content.edit', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form
                                                    action="{{ route('modules.professor.content.destroy', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('modules.professor.folder.edit', ['module_id' => $module->module_id, 'folder' => $folder->module_folder_id]) }}"
                                class="btn btn-warning btn-sm">Edit Folder</a>
                            <form
                                action="{{ route('modules.professor.folder.destroy', ['module_id' => $module->module_id, 'folder' => $folder->module_folder_id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete Folder</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('modules.professor.folder.create', ['module_id' => $module->module_id]) }}"
                class="btn btn-success">Add Folder</a>
            <a href="{{ route('modules.professor.content.create', ['module_id' => $module->module_id]) }}"
                class="btn btn-primary">Add Content</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</x-layout>
