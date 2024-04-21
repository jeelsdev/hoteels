<?php

namespace App\Livewire\Admin\Room;

use App\Models\Room;
use App\Models\RoomType;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateRoom extends Component
{
    public $roomTypes = [];

    #[Validate(['required'])]
    public $roomType;
    #[Validate(['required'])]
    public $code;
    #[Validate(['required', 'numeric'])]
    public $floor;
    public $description;

    public function resetInputs()
    {
        $this->reset(['roomType', 'code', 'floor', 'description']);
    }

    public function save()
    {
        $this->validate();
        $room = new Room();
        $room->room_type_id = $this->roomType;
        $room->code = $this->code;
        $room->floor = $this->floor;
        $room->description = $this->description;
        $room->save();

        $this->resetInputs();
        session()->flash('flash.message', 'Habitación creada correctamente.');
        return redirect()->route('room.index');
    }

    public function render()
    {
        $this->roomTypes = RoomType::all();
        return view('livewire.admin.room.create-room');
    }
}
