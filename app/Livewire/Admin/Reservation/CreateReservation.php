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

class CreateReservation extends Component
{
    public $open = false;
    public $data;
    public $rooms = [];
    public $users = [];
    public $statuses = [];
    public $origins = [];
    public $xtras = [];
    public $tours = [];

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
    public $userFavorite = false;
    public $isFavorite = false;

    public $showPendingPayment = false;

    public function isFavoriteUser()
    {
        if($this->usersTotal[0])
        {
            $user = User::find($this->usersTotal[0]);
            $this->isFavorite = true;
            $this->userFavorite = $user->favorite;
        }else {
            $this->isFavorite = false;
        }
    }

    public function addFavoriteUser()
    {
        $this->userFavorite? $this->userFavorite = false : $this->userFavorite = true;
    }

    public function checkStatusPending()
    {
        if($this->status == 'pending') {
            $this->showPendingPayment = true;
        }else {
            $this->showPendingPayment = false;
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

    #[On('openModalCreate')]
    public function openModal($data)
    {
        $date = Carbon::parse($data['date'] ? $data['date'] : $data['date']);
        $this->room_id = $data['resource']['id'];
        $this->open = true;
        $this->start_date = $date->format('Y-m-d');
        $this->end_date = $date->addDay()->format('Y-m-d');
        $room = Room::find($this->room_id);
        $this->price = $room->roomType->price;
        $this->calculateTotalPrice();
    }

    public function updated()
    {
        $this->calculateTotalPrice();
    }

    public function resetInputs()
    {
        $this->reset(['start_date', 'end_date', 'room_id', 'status', 'origin', 'total', 'comments', 'pending_payment', 'price', 'inputUsers', 'inputXtras', 'inputTours', 'xtrasPayment', 'toursPayment', 'xtrasTotal', 'toursTotal', 'usersTotal', 'uI', 'tI', 'xI', 'userFavorite', 'isFavorite', 'showPendingPayment']);
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

        if($this->userFavorite)
        {
            $user = User::find($this->usersTotal[0]);
            $user->favorite = true;
            $user->save();
        }

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

        session()->flash('flash.message', '¡Reservación creada con éxito!');
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
        return view('livewire.admin.reservation.create-reservation');
    }
}
