<?php

namespace App\Livewire\Professor;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public $logoLightUrl;
    public $logoDarkUrl;
    public $modules;
    public $userName;
    public $userProfileUrl;
    public $currentPage;
    public $currentModule;

    public function mount($currentPage, $currentModule = null)
    {
        abort_if(!Auth::user()?->isProfessor(), 403);

        $this->logoLightUrl = '/images/logo-transparent-white.png';
        $this->logoDarkUrl = '/images/logo-transparent-dark.png';
        $this->userName = Auth::user()->first_name;
        $this->modules = DB::table('modules')
            ->join('teaches', 'modules.module_id', '=', 'teaches.module_id')
            ->where('teaches.user_id', Auth::user()->user_id)
            ->select('modules.module_name', 'modules.module_id')
            ->get();
        $nameFirstChar = strtolower($this->userName[0]);
        $this->userProfileUrl = Auth::user()->profile_picture ?? "/images/default-profiles/{$nameFirstChar}.png";
        $this->currentPage = $currentPage;
        $this->currentModule = $currentModule;
    }

    public function placeholder()
    {
        return view('components.spinner');
    }

    public function render()
    {
        return view('livewire.professor.sidebar', [
            'logoLightUrl' => $this->logoLightUrl,
            'logoDarkUrl' => $this->logoDarkUrl,
            'modules' => $this->modules,
            'userProfileUrl' => $this->userProfileUrl,
            'userName' => $this->userName,
            'currentPage' => $this->currentPage,
            'currentModule' => $this->currentModule,
        ]);
    }
}
