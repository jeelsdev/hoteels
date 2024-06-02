<?php

namespace App\Livewire\Admin\Room;

use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ShowRooms extends Component
{
    public $search = '';
    
    public $roomTypes = [];
    public $roomType;
    public $floor;


    #[On('roomCreated')]
    public function render()
    {
        $rooms = Room::where('code', 'like', '%'.$this->search.'%')
            ->whereHas('roomType', function ($query) {
                if ($this->roomType){
                    $query->where('denomination', $this->roomType);
                }
            })->when($this->floor, function ($query) {
                $query->orderBy('floor', $this->floor);
            })->paginate(20);

        $this->roomTypes = getEnumValues('RoomType');
        return view('livewire.admin.room.show-rooms', compact('rooms'));
    }
}
