<?php

namespace App\Livewire\Admin\Room;

use App\Models\Room;
use Livewire\Component;

class ShowRooms extends Component
{
    public $rooms = [];

    public function render()
    {
        $this->rooms = Room::all();
        return view('livewire.admin.room.show-rooms');
    }
}
