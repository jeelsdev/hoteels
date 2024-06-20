<?php

namespace App\Livewire\Admin\Room\Floor;

use App\Models\Floor as ModelsFloor;
use Livewire\Component;

class Floor extends Component
{
    public $search;
    public $floors;
    public function getFloors()
    {
        $this->floors = ModelsFloor::when($this->search, function ($query) {
            $query->where("description","like","%". $this->search ."%");
            })->orderBy('denomination','asc')
            ->get();
    }
    public function render()
    {
        $this->getFloors();
        return view('livewire.admin.room.floor.floor');
    }
}
