<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Favourite;
use App\Models\ModuleContent;
use App\Models\ModuleFolder;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Auth;

// TODO: lazy load, spinner,  search, filter, download all

class ContentTable extends Component
{
    public $module_id;
    public $folders;
    public $currentFolder = null;
    public $selectedContentIds = [];
    public $search = '';
    public $sort = 'latest';
    public $sortColumn = 'upload_date';
    public $sortOrder = 'desc';

    public function mount($module_id)
    {
        $this->module_id = $module_id;
    }

    #[Renderless] 
    public function updateCurrentFolder($folder_id)
    { 
        $this->currentFolder = $folder_id;
    }

    public function favourite($content_id)
    { 
        $user = Auth::user();
        $favourite = Favourite::where('user_id', Auth::user()->user_id)
            ->where('content_id', $content_id)
            ->first();

        if ($favourite) {
            $favourite->delete();
        } else {
            Favourite::create([
                'user_id' => $user->user_id,
                'content_id' => $content_id,
                'module_id' => $this->module_id
            ]);
        }
    }

    #[Renderless] 
    public function toggleSelectContentId($content_id)
    { 
        if (in_array($content_id, $this->selectedContentIds)) {
            $this->selectedContentIds = array_diff($this->selectedContentIds, [$content_id]);
        } else {
            $this->selectedContentIds[] = $content_id;
        }
    }

    public function toggleSelectAllContentId($module_folder_id)
    {
        foreach ($this->folders as $folder) {
            if ($folder->module_folder_id == $module_folder_id) {
                foreach ($folder->contents as $content) {
                    if (in_array($content->content_id, $this->selectedContentIds)) {
                        $this->selectedContentIds = array_diff($this->selectedContentIds, [$content->content_id]);
                    } else {
                        $this->selectedContentIds[] = $content->content_id;
                    }
                }
            }
        }
    }

    public function updateSort($sort)
    {
        switch ($sort) {
            case 'title_asc':
                $this->sortColumn = 'title';
                $this->sortOrder = 'asc';
                $this->sort = 'title_desc';
                break;
            case 'title_desc':
                $this->sortColumn = 'title';
                $this->sortOrder = 'desc';
                $this->sort = 'title_asc';
                break;
            case 'earliest':
                $this->sortColumn = 'upload_date';
                $this->sortOrder = 'asc';
                $this->sort = 'latest';
                break;
            case 'latest':
                $this->sortColumn = 'upload_date';
                $this->sortOrder = 'desc';
                $this->sort = 'earliest';
                break;
            default:
                $this->sortColumn = 'upload_date';
                $this->sortOrder = 'desc';
                $this->sort = 'latest';
        }
    }

    public function render()
    {
        $this->folders = ModuleFolder::where('module_id', $this->module_id)
            ->with([
                'contents' => fn ($query) => $query
                    ->orderBy($this->sortColumn, $this->sortOrder)
                    ->where('title', 'like', '%'.$this->search.'%')
            ])
            ->get();
        if ($this->folders->isEmpty()) {
            $this->currentFolder = 'favourites';
        } else if ($this->currentFolder == null) {
            $this->currentFolder = $this->folders->first()->module_folder_id;
        }
        return view('livewire.student.content-table', [
            'folders' => $this->folders
        ]);
    }
}

