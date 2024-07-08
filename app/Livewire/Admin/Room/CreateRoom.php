<?php

namespace App\Livewire\Admin\Room;

use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomType;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateRoom extends Component
{
    public $roomTypes = [];
    public $floors = [];

    #[Validate(['required', 'exists:room_types,id'])]
    public $roomType;
    #[Validate(['required', 'unique:rooms,code'])]
    public $code;
    #[Validate(['required', 'exists:floors,id'])]
    public $floor;
    public $description;

    public function save()
    {
        $this->validate();
        $room = new Room();
        $room->room_type_id = $this->roomType;
        $room->code = $this->code;
        $room->floor = $this->floor;
        $room->description = isset($this->description) ? $this->description : '';
        $room->save();
        session()->flash('flash.message', 'Habitación creada correctamente.');
        return redirect()->route('room.index');
    }

    public function render()
    {
        $this->roomTypes = RoomType::all();
        $this->floors = Floor::all();
        return view('livewire.admin.room.create-room');
    }
}
