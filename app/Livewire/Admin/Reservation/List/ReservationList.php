<?php

namespace App\Livewire\Admin\Reservation\List;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationList extends Component
{
    use WithPagination;
    
    public function render()
    {
        $reservationLists = Reservation::whereHas("users", function ($query) {
            $query->where('reserver', '1');
        })->with([
            'users',
            'payment',
            'room'
        ])->orderBy('created_at','desc')
        ->paginate(20);

        return view('livewire.admin.reservation.list.reservation-list', compact('reservationLists'));
    }
}
