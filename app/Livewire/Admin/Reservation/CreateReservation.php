<?php

namespace App\Livewire\Admin\Reservation;

use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateReservation extends Component
{
    public $open = false;
    public $data;
    public $start_date;
    public $end_date;
    public $room_id;
    public $customer_id;

    #[On('openModal')]
    public function openModal($data)
    {
        $start_date = Carbon::parse($data['date'] ? $data['date'] : $data['date'])->format('Y-m-d');
        // dd($start_date);
        $this->open = true;
        $this->start_date = $start_date;
    }

    public function render()
    {
        return view('livewire.admin.reservation.create-reservation');
    }
}
