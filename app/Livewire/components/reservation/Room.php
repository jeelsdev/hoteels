<?php

namespace App\Livewire\Components\Reservation;

use App\Models\Room as ModelsRoom;
use Livewire\Component;

class Room extends Component
{
    public String $roomCode;

    public String $roomType;

    public String $floor;
    
    public int $price;

    public function mount(ModelsRoom $room)
    {
        $this->roomCode = $room->code;
        $this->roomType = $room->roomType->description;
        $this->floor = $room->floor;
        $this->price = $room->roomType->price;
    }

    public function render()
    {
        return view('livewire.components.reservation.room');
    }
}
