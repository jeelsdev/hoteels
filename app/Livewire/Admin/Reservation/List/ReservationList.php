<?php

namespace App\Livewire\Admin\Reservation\List;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationList extends Component
{
    use WithPagination;

    public $fromDate;
    public $toDate;
    public $total;

    public function updateData()
    {
        $this->getTotal();
    }

    public function getTotal()
    {
        $this->total = Reservation::whereHas("users", function ($query) {
            $query->where('reserver', '1');
        })->when($this->fromDate, function ($query) {
            $query->whereDate('entry_date', '>=', $this->fromDate);
        })->when($this->toDate, function ($query) {
            $query->whereDate('entry_date', '<=', $this->toDate);
        })->count();
    }

    protected function getReservationLists()
    {
        return Reservation::whereHas("users", function ($query) {
            $query->where('reserver', '1');
        })->with([
            'users',
            'payment',
            'room'
        ])->when($this->fromDate, function ($query) {
            $query->whereDate('entry_date', '>=', $this->fromDate);
        })->when($this->toDate, function ($query) {
            $query->whereDate('entry_date', '<=', $this->toDate);
        })->orderBy('entry_date','desc')
        ->paginate(20);
    }

    public function mount()
    {
        $this->fromDate = now()->startOfMonth()->format('Y-m-d');
        $this->toDate = now()->endOfMonth()->format('Y-m-d');
        $this->getTotal();
    }
    
    public function render()
    {
        $reservationLists = $this->getReservationLists();

        return view('livewire.admin.reservation.list.reservation-list', compact('reservationLists'));
    }
}
