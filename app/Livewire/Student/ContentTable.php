<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Favourite;
use App\Models\ModuleFolder;
use Livewire\WithPagination;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Auth;

class ContentTable extends Component
{
    use WithPagination;

    public $module_id;
    public $currentFolder;
    public $currentPage;
    public $selectedContentIds;
    public $query;
    protected $paginationTheme = 'bootstrap';

    public function mount($module_id)
    {
        $this->module_id = $module_id;    
        $this->currentFolder = 0;
        $this->currentPage = 1;
        $this->selectedContentIds = [];
    }

    public function loadMore()
    {
        $this->currentPage++;
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

    public function render()
    {
        $folders = ModuleFolder::where('module_id', $this->module_id)->get();
        return view('livewire.student.content-table', [
            'folders' => $folders
        ]);
    }
}

