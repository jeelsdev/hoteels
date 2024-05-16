<?php

namespace App\Livewire\Admin\Reservation;

use App\Models\Reservation;
use App\Models\Room;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowReservations extends Component
{
    public $rooms = [];
    public $reservations = [];

    #[On('edit-reservation')]
    public function editRedirect($data)
    {
        $data = [
            'start' => $data['event']['start'],
            'end' => $data['event']['end'],
            'resource' => $data['event']['extendedProps']['custom_data']['room_id'],
            'reservation' => $data['event']['extendedProps']['custom_data']['reservation_id'],
        ];
        $data = http_build_query($data);
        
        return redirect()->route('reservation.edit', ['data'=>$data]);
    }

    #[On('create-reservation')]
    public function createRedirect($data)
    {
        $data = [
            'date' => $data['date'],
            'resource' => $data['resource']['id'],
        ];
        $data = http_build_query($data);
        return redirect()->route('reservation.create', ['data'=>$data]);
    }

    #[On('reservation-created')]
    public function render()
    {
        $this->rooms = Room::with('roomType')
            ->orderBy('floor', 'asc')
            ->get();

        $this->reservations = Reservation::all();
//dd($this->reservations[0]->users[0]->pivot);
        return view('livewire.admin.reservation.show-reservations');
    }
}
