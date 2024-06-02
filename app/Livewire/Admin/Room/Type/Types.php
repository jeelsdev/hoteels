<?php

namespace App\Livewire\Admin\Room\Type;

use App\Models\RoomType;
use Livewire\Component;

class Types extends Component
{
    public $search;
    public $roomTypes;
    public function getRoomTypes()
    {
        $this->roomTypes = RoomType::when($this->search, function ($query) {
            $query->where("description","like","%". $this->search ."%");
            })->orderBy('created_at','desc')
            ->get();
    }
    public function render()
    {
        $this->getRoomTypes();
        return view('livewire.admin.room.type.types');
    }
}
