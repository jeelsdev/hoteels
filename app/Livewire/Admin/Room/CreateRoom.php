<?php

namespace App\Livewire\Admin\Room;

use App\Models\RoomType;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateRoom extends Component
{
    public $roomType = [];
    public $code;
    public $floor;
    public $description;
    public $open = false;

    #[On('openCreateRoomModal')]
    public function openModal()
    {
        dd("Hola");
        $this->open = true;
    }
    public function render()
    {
        $this->roomType = RoomType::all();
        return view('livewire.admin.room.create-room');
    }
}
