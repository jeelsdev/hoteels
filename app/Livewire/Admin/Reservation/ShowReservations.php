<?php

namespace App\Livewire\Admin\Reservation;

use Livewire\Attributes\On;
use Livewire\Component;

class ShowReservations extends Component
{
    #[On('edit-reservation')]
    public function editRedirect($data)
    {
        $data = [
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
            'date' => $data['dateStr'],
            'resource' => $data['resource']['id'],
        ];
        $data = http_build_query($data);
        return redirect()->route('reservation.create', ['data'=>$data]);
    }

    public function mount($rooms, $reservations)
    {
        // See the 'load-calendar' event in resources/js/fullcalendar.js
        $this->dispatch('load-calendar', [
            'rooms' => $rooms,
            'reservations' => $reservations,
        ]);
    }

    #[On('reservation-created')]
    public function render()
    {
        return view('livewire.admin.reservation.show-reservations');
    }
}
