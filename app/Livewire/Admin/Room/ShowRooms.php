<?php

namespace App\Livewire\Admin\Room;

use App\Models\Room;
use Livewire\Component;

class ShowRooms extends Component
{
    public $search = '';

    public function dispatchOpenModal()
    {
        $this->dispatch('openCreateRoomModal')->to(CreateRoom::class);
    }

    public function render()
    {
        $rooms = Room::where('code', 'like', '%'.$this->search.'%')
            ->paginate(20);
        return view('livewire.admin.room.show-rooms', compact('rooms'));
    }
}
