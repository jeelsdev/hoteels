<?php

namespace App\Livewire\Admin\Reservation;

use App\Enums\Origin;
use App\Enums\Status;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Tour;
use App\Models\User;
use App\Models\Xtra;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditReservation extends Component
{
    public $open = false;
    public $data;
    public $rooms = [];
    public $users = [];
    public $statuses = [];
    public $origins = [];
    public $xtras = [];
    public $tours = [];
    public $reservation;

    #[Validate('required')]
    public $start_date;

    #[Validate('required')]
    public $end_date;

    #[Validate('required')]
    public $room_id;

    #[Validate('required')]
    public $origin;

    #[Validate('required')]
    public $status;

    #[Validate('required')]
    public $total;

    #[Validate(['numeric', 'regex:/^\d+$/'])]
    public $price;

    public $comments;
    public $pending_payment;
    public $usersTotal = [];
    public $xtrasTotal = [];
    public $toursTotal = [];

    public $inputUsers = [];
    public $inputXtras = [];
    public $inputTours = [];

    public $xtrasPayment = [];
    public $toursPayment = [];

    public $uI = 0;
    public $tI = 0;
    public $xI = 0;

    public $showPendingPayment = false;

    public function checkStatusPending()
    {
        if($this->status == 'pending') {
            $this->showPendingPayment = true;
        }
    }

    public function addUser($i)
    {
        $i = $i + 1;
        $this->uI = $i;
        array_push($this->inputUsers, $i);
    }

    public function addTour($i)
    {
        $i = $i + 1;
        $this->tI = $i;
        array_push($this->inputTours, $i);
    }
    
    public function addXtra($i)
    {
        $i = $i + 1;
        $this->xI = $i;
        array_push($this->inputXtras, $i);
    }

    public function addXtraPayment($i)
    {
        $idXtra = $this->xtrasTotal[$i];
        $this->xtrasPayment[$i] = Xtra::find($idXtra)->price;
        $this->calculateTotalPrice();
    }

    public function addTourPayment($i)
    {
        $idTour = $this->toursTotal[$i];
        $this->toursPayment[$i] = Tour::find($idTour)->price;
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $days = $start->diffInDays($end);
        $xtrasPaymentTotal = 0;
        $toursPaymentTotal = 0;

        if(!empty($this->xtrasPayment))
        {
            $xtrasPaymentTotal = array_sum($this->xtrasPayment);
        }

        if(!empty($this->toursPayment))
        {
            $toursPaymentTotal = array_sum($this->toursPayment);
        }

        if(is_numeric($this->price) && $this->price >= 0)
        {
            $this->total = ($days * $this->price) + $xtrasPaymentTotal + $toursPaymentTotal;
        }
    }

    #[On('open-modal-edit')]
    public function openModal($data)
    {
        $start = Carbon::parse($data['event']['start']);
        $end = Carbon::parse($data['event']['end']);
        $this->room_id = $data['event']['extendedProps']['custom_data']['room_id'];
        $reservation_id = $data['event']['extendedProps']['custom_data']['reservation_id'];
        $this->open = true;
        $this->start_date = $start->format('Y-m-d');
        $this->end_date = $end->format('Y-m-d');
        $room = Room::find($this->room_id);
        $this->reservation = Reservation::find($reservation_id);
        $this->total = $this->reservation->total;
        if($this->reservation->pending_payment) {
            $this->showPendingPayment = true;
            $this->pending_payment = $this->reservation->pending_payment;
        }
        $this->comments = $this->reservation->comments;
        $this->price = $room->roomType->price;
    }

    public function updated()
    {
        $this->calculateTotalPrice();
    }

    public function resetInputs()
    {
        $this->reset(['start_date', 'end_date', 'room_id', 'status', 'origin', 'total', 'comments', 'pending_payment', 'price', 'inputUsers', 'inputXtras', 'inputTours', 'xtrasPayment', 'toursPayment', 'xtrasTotal', 'toursTotal', 'usersTotal', 'uI', 'tI', 'xI']);
        $this->open = false;
    }

    public function save()
    {
        $this->validate();
        
        if($this->status == 'pending') {
            $this->validate([
                'pending_payment' => 'required|numeric',
            ]);
        }else {
            $this->pending_payment = null;
        }

        $reservation = Reservation::create([
            'entry_date' => $this->start_date,
            'exit_date' => $this->end_date,
            'room_id' => $this->room_id,
            'status' => $this->status,
            'origin' => $this->origin,
            'comments' => $this->comments,
            'pending_payment' => $this->pending_payment,
            'total' => $this->total,
        ]);

        if(!empty($this->usersTotal))
        {
            $reservation->users()->attach($this->usersTotal);
        }

        if(!empty($this->xtrasTotal))
        {
            $reservation->xtras()->attach($this->xtrasTotal);
        }

        if(!empty($this->toursTotal))
        {
            $reservation->tours()->attach($this->toursTotal);
        }

        $this->resetInputs();

        session()->flash('message', '¡Reservación creada con éxito!');
        // $this->dispatch('reservation-created');
        return redirect()->route('reservation.index');
    }

    public function render()
    {
        $this->users = User::all();
        $this->statuses = Status::getArrayValues();
        $this->rooms = Room::all();
        $this->origins = Origin::getArrayValues();
        $this->xtras = Xtra::all();
        $this->tours = Tour::all();
        return view('livewire.admin.reservation.edit-reservation');
    }
}