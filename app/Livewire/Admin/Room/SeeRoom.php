<?php

namespace App\Livewire\Admin\Room;

use App\Http\Controllers\RoomHistoryController;
use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\RoomType;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SeeRoom extends Component
{
    public Room $room;
    public $roomHistories = [];

    #[Validate(['required'])]
    public $status;
    public $roomType;
    public $code;
    public $floor;
    public $description;

    public function resetInputs()
    {
        $this->reset(['status']);
    }

    public function save()
    {
        $this->validate();
        $this->room->status = $this->status;
        $this->room->save();

        $this->room->roomHistories()->create([
            'from' => now(),
            'status' => $this->status,
        ]);

        $this->resetInputs();
        session()->flash('flash.message', 'Estado actualizado.');
        return redirect()->route('room.rooms');
    }

    private function getRoomHitories($id)
    {
        $this->roomHistories = RoomHistory::where('room_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
    }
    
    public function mount($id)
    {
        $this->room = Room::findOrfail($id);
        $this->roomType = $this->room->roomType->description;
        $this->code = $this->room->code;
        $this->floor = $this->room->floor;
        $this->description = $this->room->description;
        $this->status = $this->room->status;
        $this->getRoomHitories($id);
    }
    public function render()
    {
        return view('livewire.admin.room.see-room');
    }
}
