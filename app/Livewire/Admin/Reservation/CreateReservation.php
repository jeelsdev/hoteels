<?php

namespace App\Livewire\Admin\Reservation;

use App\Enums\Origin;
use App\Enums\Status;
use App\Models\Payment;
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

    // users data
    public $user;
    public $name;
    public $lastName;
    public $email;
    public $phone;
    public $documentType;
    public $document;

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
    public $total_reservation;

    public $total_xtras;

    public $total_tours;

    #[Validate(['numeric', 'regex:/^\d+$/'])]
    public $price;

    public $comments;
    public $pending_payment;
    public $advance_reservation;
    public $advance_xtras;
    public $advance_tours;
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
    public $createWithNewUser = false;

    public $showAdvanceReservation = false;

    public function showCreateWithNewUser()
    {
        $this->createWithNewUser = true;
        $this->usersTotal[0] = null;
        $this->uI = 1;
    }

    // remove input user
    public function removeInputUser($key, $value)
    {
        unset($this->inputUsers[$key]);
        unset($this->usersTotal[$value]);
    }
    
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

        // user find data
        $this->user = User::find($this->usersTotal[0]);
        $this->documentType = $this->user->document_type;
        $this->document = $this->user->document;
    }

    public function addFavoriteUser()
    {
        $this->userFavorite? $this->userFavorite = false : $this->userFavorite = true;
    }

    public function checkStatusPending()
    {
        if($this->status == 'booking') {
            $this->showAdvanceReservation = true;
        }else {
            $this->showAdvanceReservation = false;
        }
    }

    public function addUser($i)
    {
        $i = $i + 1;
        $this->uI = $i;
        array_push($this->inputUsers, $i);
    }

    // remove input tour
    public function removeInputTour($key, $value)
    {
        unset($this->inputTours[$key]);
        unset($this->toursTotal[$value]);
        unset($this->toursPayment[$value]);
        $this->calculateTotalPrice();
    }

    public function addTour($i)
    {
        $i = $i + 1;
        $this->tI = $i;
        array_push($this->inputTours, $i);
    }
    
    // remove input xtra
    public function removeInputXtra($key, $value)
    {
        unset($this->inputXtras[$key]);
        unset($this->xtrasTotal[$value]);
        unset($this->xtrasPayment[$value]);
        $this->calculateTotalPrice();
    }

    public function addXtra($i)
    {
        $i = $i + 1;
        $this->xI = $i;
        array_push($this->inputXtras, $i);
    }

    public function addXtraPayment($key)
    {
        $idXtra = $this->xtrasTotal[$key];
        $this->xtrasPayment[$key] = Xtra::find($idXtra)->price;
        $this->calculateTotalPrice();
    }

    public function addTourPayment($key)
    {
        $idTour = $this->toursTotal[$key];
        $this->toursPayment[$key] = Tour::find($idTour)->price;
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $days = $start->diffInDays($end);

        if(!empty($this->xtrasPayment))
        {
            $this->total_xtras = array_sum($this->xtrasPayment);
        }

        if(!empty($this->toursPayment))
        {
            $this->total_tours = array_sum($this->toursPayment);
        }

        if(is_numeric($this->price) && $this->price >= 0)
        {
            $this->total_reservation = $days * $this->price;
        }

        // calculate pending payment
        if(is_numeric($this->advance_reservation) && $this->advance_reservation > 0 && $this->advance_reservation <= $this->total_reservation)
        {
            $this->pending_payment = $this->total_reservation - $this->advance_reservation;
        }else{
            $this->pending_payment = $this->total_reservation;
        }
    }

    #[On('openModalCreate')]
    public function openModal($data)
    {
        $date = Carbon::parse($data['date']);
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
        $this->reset([
            'start_date',
            'end_date',
            'room_id',
            'origin',
            'status',
            'total_reservation',
            'total_xtras',
            'total_tours',
            'price',
            'comments',
            'pending_payment',
            'advance_reservation',
            'advance_xtras',
            'advance_tours',
            'usersTotal',
            'xtrasTotal',
            'toursTotal',
            'inputUsers',
            'inputXtras',
            'inputTours',
            'xtrasPayment',
            'toursPayment',
            'uI',
            'tI',
            'xI',
            'userFavorite',
            'isFavorite',
            'createWithNewUser',
            'showAdvanceReservation',
            'name',
            'lastName',
            'email',
            'phone',
            'documentType',
            'document',
        ]);
        $this->open = false;
    }

    public function save()
    {
        $this->validate();
        
        if($this->status == 'booking') {
            $this->validate([
                'advance_reservation' => 'required|numeric',
            ]);
        }else {
            $this->advance_reservation = null;
        }

        $reservation = Reservation::create([
            'entry_date' => $this->start_date,
            'exit_date' => $this->end_date,
            'room_id' => $this->room_id,
            'status' => $this->status,
            'origin' => $this->origin,
            'comments' => $this->comments,
        ]);

        Payment::create([
            'reservation_id' => $reservation->id,
            'total_reservation' => $this->total_reservation,
            'total_xtras' => $this->total_xtras,
            'total_tours' => $this->total_tours,
            'advance_reservation' => $this->advance_reservation,
            'advance_xtras' => $this->advance_xtras,
            'advance_tours' => $this->advance_tours,
            'type' => 'CASH',
        ]);

        if($this->createWithNewUser)
        {
            $this->createWithNewUser($reservation);
        }else{
            $this->createWithExistingUser($reservation);
        }

        if(!empty($this->xtrasTotal))
        {
            foreach($this->xtrasTotal as $key => $xtra)
            {
                $reservation->xtras()->attach($xtra, ['total' => $this->xtrasPayment[$key]]);
            }
        }

        if(!empty($this->toursTotal))
        {
            foreach($this->toursTotal as $key => $tour)
            {
                $reservation->tours()->attach($tour, ['total' => $this->toursPayment[$key]]);
            }
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

    public function createWithNewUser($reservation)
    {
        $this->validate([
            'name' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'documentType' => 'required',
            'document' => 'required',
        ]);

        $user = User::create([
            'name' => $this->name,
            'surname' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'document_type' => $this->documentType,
            'document' => $this->document,
            'password' => bcrypt('password'),
        ]);

        if($this->userFavorite)
        {
            $user->favorite = true;
        }

        $user->save();
        $reservation->users()->attach($user->id, ['total' => $this->price, 'reserver' => true]);
        unset($this->usersTotal[0]);

        if(!empty($this->usersTotal))
        {
            $reservation->users()->attach($this->usersTotal, ['total' => $this->price]);
        }
        
    }

    public function createWithExistingUser($reservation)
    {
        $user = User::find($this->usersTotal[0]);

        if($this->userFavorite)
        {
            $user->favorite = true;
        }
        
        $user->document_type = $this->documentType;
        $user->document = $this->document;
        $user->save();
        
        $reservation->users()->attach($user->id, ['total' => $this->price, 'reserver' => true]);
        unset($this->usersTotal[0]);
        
        if(!empty($this->usersTotal))
        {
            $reservation->users()->attach($this->usersTotal, ['total' => $this->price]);
        }
        


    }
}
