<?php

namespace App\Livewire\Admin\Room;

use App\Http\Controllers\RoomHistoryController;
use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;

class Rooms extends Component
{
    public $rooms;
    public $roomTypes;
    public $roomType;
    public $status;

    public function redirectReservation($id)
    {
        $data = [
            'date' => now()->format('Y-m-d'),
            'resource' => $id,
        ];
        $data = http_build_query($data);
        return redirect()->route('reservation.create', ['data'=>$data]);
    }

    public function setMaintenance($id)
    {
        $room = Room::findOrFail($id);
        $room->status = 'maintenance';
        $room->save();

        $room->roomHistories()->create([
            'from' => now(),
            'status' => 'maintenance',
        ]);
    }

    public function setAvailable($id)
    {
        $room = Room::findOrFail($id);
        $room->status = 'available';
        $room->save();

        $room->roomHistories()->create([
            'from' => now(),
            'status' => 'available',
        ]);
    }

    public function setClean($id)
    {
        $room = Room::findOrFail($id);
        $room->status = 'clean';
        $room->save();

        $room->roomHistories()->create([
            'from' => now(),
            'status' => 'clean',
        ]);
    }

    private function getRooms()
    {
        $this->rooms = Room::when($this->roomType, function ($query) {
            return $query->where('room_type_id', $this->roomType);
        })->when($this->status, function ($query) {
            return $query->where('status', $this->status);
        })->get();
    }

    public function render()
    {
        $rhc = new RoomHistoryController();
        $rhc->checkStatusRooms();
        $this->getRooms();
        $this->roomTypes = RoomType::all();
        return view('livewire.admin.room.rooms');
    }
}
