<?php

namespace App\Livewire\Admin\Service\Tour;

use App\Models\Tour;
use Livewire\Attributes\On;
use Livewire\Component;

class Tours extends Component
{
    public $search = '';

    #[On('refreshTours')]
    public function render()
    {
        $tours = Tour::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'desc')->paginate(20);
        return view('livewire.admin.service.tour.tours', compact('tours'));
    }
}
