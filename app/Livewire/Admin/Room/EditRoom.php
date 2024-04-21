<?php

namespace App\Livewire\Admin\Room;

use App\Models\Room;
use App\Models\RoomType;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditRoom extends Component
{
    public $roomTypes = [];
    public Room $room;

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
        session()->flash('flash.message', 'Habitación actualizada correctamente.');
        return redirect()->route('room.index');
    }
    
    public function mount($id)
    {
        $this->room = Room::findOrfail($id);
        $this->roomTypes = RoomType::all();
        $this->roomType = $this->room->room_type_id;
        $this->code = $this->room->code;
        $this->floor = $this->room->floor;
        $this->description = $this->room->description;
    }

    public function render()
    {
        return view('livewire.admin.room.edit-room');
    }
}
