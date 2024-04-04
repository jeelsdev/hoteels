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

    #[On('reservation-created')]
    public function render()
    {
        $this->rooms = Room::with('roomType')
            ->orderBy('floor', 'asc')
            ->get();

        $this->reservations = Reservation::orderBy('entry_date', 'asc')
            ->get();

        return view('livewire.admin.reservation.show-reservations');
    }
}
