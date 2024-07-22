<div id="content-table">
    <div class="d-flex">
        <div class="me-auto">
            @if ($folders->isEmpty())
                <p class="p-3">No content found.</p>
            @else
                <ul class="nav nav-pills gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;"
                    id="content-tab" role="tablist">
                    @foreach ($folders as $folder)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link rounded-5 {{ $currentFolder == $folder->module_folder_id ? 'active' : '' }}"
                                id="tab-{{ $folder->module_folder_id }}" data-bs-toggle="tab"
                                href="#folder-{{ $folder->module_folder_id }}" role="tab"
                                aria-controls="folder-{{ $folder->module_folder_id }}"
                                aria-selected="{{ $currentFolder == $folder->module_folder_id ? 'true' : 'false' }}"
                                wire:click="updateCurrentFolder({{ $folder->module_folder_id}})">{{ $folder->folder_name }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item" role="presentation">
                        <a id="tab-favourites" class="nav-link rounded-5 {{ $currentFolder == 'favourites' ? 'active' : '' }}"
                            data-bs-toggle="tab" href="#folder-favourites" role="tab"
                            aria-controls="folder-favourites"
                            aria-selected="{{ $currentFolder == 'favourites' ? 'true' : 'false' }}"
                            wire:click="updateCurrentFolder('favourites')">Favourites</a>
                    </li>
                </ul>
            @endif
        </div>
        <div class="me-3">
            <button id="download-btn" class="btn btn-primary {{ count($selectedContentIds) > 0 ? '' : 'd-none' }}"
                wire:click="downloadSelectedContent()">Download</button>
        </div>
        <div class="row g-3">
            <div class="col-auto ">
                <input type="text" id="search-input" class="form-control" aria-describedby="search-input"
                    placeholder="Search..." wire:model.live="search">
            </div>
        </div>
    </div>
    <div class="tab-content" id="folderTab">
        @foreach ($folders as $folder)
            <div class="tab-pane fade {{ $currentFolder == $folder->module_folder_id ? 'show active' : '' }}"
                id="folder-{{ $folder->module_folder_id }}" role="tabpanel"
                aria-labelledby="tab-{{ $folder->module_folder_id }}">
                @if ($folder->contents->isEmpty())
                    <p class="p-3">No content found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input class="form-check-input content-check" type="checkbox" value=""
                                        wire:click="toggleSelectAllContentId({{ $folder->module_folder_id }})">
                                </th>
                                <th scope="col"
                                    wire:click="updateSort('{{ $sortColumn != 'title' ? 'title_desc' : $sort }}')"
                                    role="button">
                                    Title
                                    @if ($sort == 'title_asc')
                                        <i class="bi bi-arrow-down"></i>
                                    @elseif ($sort == 'title_desc')
                                        <i class="bi bi-arrow-up"></i>
                                    @endif
                                </th>
                                <th scope="col"
                                    wire:click="updateSort('{{ $sortColumn != 'upload_date' ? 'latest' : $sort }}')"
                                    role="button">
                                    Time Uploaded
                                    @if ($sort == 'earliest')
                                        <i class="bi bi-arrow-down"></i>
                                    @elseif ($sort == 'latest')
                                        <i class="bi bi-arrow-up"></i>
                                    @endif
                                </th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($folder->contents as $content)
                                <tr>
                                    <th scope="row">
                                        <input class="form-check-input content-check" type="checkbox" value=""
                                            wire:click="toggleSelectContentId({{ $content->content_id }})"
                                            {{ in_array($content->content_id, $selectedContentIds) ? 'checked' : '' }}>
                                    </th>
                                    <td><a href="{{ route('modules.student.content.show', ['module_id' => $module_id, 'content' => $content->content_id]) }}"
                                            class="no-text-decoration">
                                            {{ $content->title }}
                                        </a></td>
                                    <td>{{ $content->upload_date }}</td>
                                    <td wire:click="favourite({{ $content->content_id }})">
                                        @if ($content->is_favourited)
                                            <i class="bi bi-bookmark-fill text-primary" role="button"></i>
                                        @else
                                            <i class="bi bi-bookmark text-primary" role="button"></i>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <p class="p-3">No content found.</p>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
        <div class="tab-pane fade {{ $currentFolder == 'favourites' ? 'show active' : '' }}" id="folder-favourites" role="tabpanel" aria-labelledby="tab-favourites">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
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
                                    <td>{{ $content->upload_date }}</td>
                                    <td wire:click="favourite({{ $content->content_id }})">
                                        @if ($content->is_favourited)
                                            <i class="bi bi-bookmark-fill text-primary" role="button"></i>
                                        @else
                                            <i class="bi bi-bookmark text-primary" role="button"></i>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkboxes with the class 'content-check'
        const checkboxes = document.querySelectorAll('.content-check');
        const actionButton = document.getElementById('download-btn');

        // Function to check if any checkbox is checked
        function updateButtonVisibility(e) {
            const isAnyCheckboxChecked = Array.from(document.querySelectorAll('.content-check')).some(
                checkbox => checkbox.checked);
            if (isAnyCheckboxChecked) {
                actionButton.classList.remove('d-none');
            } else {
                actionButton.classList.add('d-none');
            }
        }
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateButtonVisibility);
        });

        // Initial check in case some checkboxes are pre-checked
        updateButtonVisibility();
    });
</script>
