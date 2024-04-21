<?php

namespace App\Livewire\Admin\Service\Xtra;

use App\Models\Xtra;
use Livewire\Attributes\On;
use Livewire\Component;

class Xtras extends Component
{
    public $search = '';

    #[On('refreshXtras')]
    public function render()
    {
        $xtras = Xtra::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'desc')->paginate(20);
        return view('livewire.admin.service.xtra.xtras', compact('xtras'));
    }
}
