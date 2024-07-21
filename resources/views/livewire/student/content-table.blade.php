<div id="content-table">
    @if ($folders->isEmpty())
        <p class="p-3">No folders in this module.</p>
    @else
        <ul class="nav nav-pills gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;"
            id="content-tab" role="tablist">
            @foreach ($folders as $folder)
                <li class="nav-item" role="presentation">
                    <a class="nav-link rounded-5 {{ $loop->first ? 'active' : '' }}"
                        id="tab-{{ $folder->module_folder_id }}" data-bs-toggle="tab"
                        href="#folder-{{ $folder->module_folder_id }}" role="tab"
                        aria-controls="folder-{{ $folder->module_folder_id }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $folder->folder_name }}</a>
                </li>
            @endforeach
            <li class="nav-item" role="presentation">
                <a class="nav-link rounded-5" id="tab-favourites" data-bs-toggle="tab" href="#folder-favourites"
                    role="tab" aria-controls="folder-favourites" aria-selected="favourites">Favourites</a>
            </li>
        </ul>
    @endif
    <div class="tab-content" id="folderTab">
        @foreach ($folders as $folder)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="folder-{{ $folder->module_folder_id }}" role="tabpanel"
                aria-labelledby="tab-{{ $folder->module_folder_id }}">
                @if ($folder->contents->isEmpty())
                    <p class="p-3">No content uploaded.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input class="form-check-input " type="checkbox" value="">
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Time Uploaded</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($folder->contents as $content)
                                <tr>
                                    <th scope="row">
                                        <input class="form-check-input" type="checkbox" value="" wire:click="toggleSelectContentId({{ $content->content_id }})">
                                    </th>
                                    <td><a href="{{ route('modules.student.content.show', ['module_id' => $module_id, 'content' => $content->content_id]) }}"
                                            class="no-text-decoration">
                                            {{ $content->title }}
                                        </a></td>
                                    <td>{{ $content->created_at->format('h:iA, d M') }}</td>
                                    <td wire:click="favourite({{ $content->content_id }})">
                                        @if ($content->is_favourited)
                                            <i class="bi bi-bookmark-fill text-primary"></i>
                                        @else
                                            <i class="bi bi-bookmark text-primary"></i>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <p class="p-3">No content uploaded.</p>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
        <div class="tab-pane fade" id="folder-favourites" role="tabpanel" aria-labelledby="tab-favourites">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Time Uploaded</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($folders as $folder)
                        @foreach ($folder->contents as $content)
                            @if ($content->is_favourited)
                                <tr>
                                    <td><a href="{{ route('modules.student.content.show', ['module_id' => $module_id, 'content' => $content->content_id]) }}"
                                            class="no-text-decoration">
                                            {{ $content->title }}
                                        </a></td>
                                    <td>{{ $folder->folder_name }}</td>
                                    <td>{{ $content->created_at->format('h:iA, d M') }}</td>
                                    <td wire:click="favourite({{ $content->content_id }})">
                                        @if ($content->is_favourited)
                                            <i class="bi bi-bookmark-fill text-primary"></i>
                                        @else
                                            <i class="bi bi-bookmark text-primary"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- {{ $folders->links() }} --}}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($folders as $folder)
            document.getElementById('select-all-{{ $folder->module_folder_id }}').addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.content-checkbox-{{ $folder->module_folder_id }}');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            document.querySelector('.download-content-ids').value = Array.from(document.querySelectorAll('.content-checkbox-{{ $folder->module_folder_id }}:checked')).map(cb => cb.value).join(',');
        @endforeach
    });
</script>