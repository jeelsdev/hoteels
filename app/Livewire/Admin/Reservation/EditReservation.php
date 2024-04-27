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
    public $payment;

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

    public $showPendingPayment = false;

    //remove input user
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

    #[On('open-modal-edit')]
    public function openModal($data)
    {
        //dates
        $start = Carbon::parse($data['event']['start']);
        $end = Carbon::parse($data['event']['end']);
        $this->start_date = $start->format('Y-m-d');
        $this->end_date = $end->format('Y-m-d');

        // room
        $this->room_id = $data['event']['extendedProps']['custom_data']['room_id'];

        // reservation
        $reservation_id = $data['event']['extendedProps']['custom_data']['reservation_id'];
        $this->reservation = Reservation::find($reservation_id);
        $this->total_reservation = $this->reservation->payment->total_reservation;
        if($this->reservation->payment->pending_payment > 0) {
            $this->showPendingPayment = true;
            $this->pending_payment = $this->reservation->payment->pending_payment;
        }

        // payment
        $this->payment = Payment::where('reservation_id', $reservation_id)->first();

        // status
        $this->status = $this->reservation->status;

        // origin
        $this->origin = $this->reservation->origin;

        // comments
        $this->comments = $this->reservation->comments;

        // price
        $this->price = $this->reservation->users[0]->pivot->total;

        // Users
        $this->usersTotal = $this->reservation->users->pluck('id')->toArray();
        $this->uI = count($this->usersTotal);
        $this->inputUsers = range(0, $this->uI-1);
        $this->isFavorite = true;
        $this->isFavoriteUser();

        // Xtras
        if($this->reservation->xtras)
        {
            foreach ($this->reservation->xtras as $key => $xtra) {
                $plus = $key + 1;
                $this->xtrasTotal["$key$plus"] = $xtra->pivot->xtra_id;
                $this->xtrasPayment["$key$plus"] = $xtra->pivot->total;
            }
            $this->xI = count($this->xtrasTotal);
            if($this->xI > 0)
            {
                $this->inputXtras = range(1, $this->xI);
            }
            $this->total_xtras = $this->reservation->payment->total_xtras;
        }

        // Tours
        if($this->reservation->tours)
        {
            foreach ($this->reservation->tours as $key => $tour) {
                $plus = $key + 1;
                $this->toursTotal["$key$plus"] = $tour->pivot->tour_id;
                $this->toursPayment["$key$plus"] = $tour->pivot->total;
            }
            $this->tI = count($this->toursTotal);
            if($this->tI > 0)
            {
                $this->inputTours = range(1, $this->tI);
            }
            $this->total_tours = $this->reservation->payment->total_tours;
        }else {
            $this->tI = 0;
            $this->inputTours = [];
        }

        // open modal
        $this->open = true;
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
            'showPendingPayment',
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
            $this->pending_payment = null;
        }

        $this->reservation->update([
            'entry_date' => $this->start_date,
            'exit_date' => $this->end_date,
            'room_id' => $this->room_id,
            'status' => $this->status,
            'origin' => $this->origin,
            'comments' => $this->comments,
        ]);

        $this->payment->update([
            'total_reservation' => $this->total_reservation,
            'total_xtras' => $this->total_xtras,
            'total_tours' => $this->total_tours,
            'advance_reservation' => $this->advance_reservation,
            'advance_xtras' => $this->advance_xtras,
            'advance_tours' => $this->advance_tours,
        ]);

        if($this->userFavorite)
        {
            $user = User::find($this->usersTotal[0]);
            $user->favorite = true;
            $user->save();
        }

        if(!empty($this->usersTotal))
        {
            foreach($this->usersTotal as $user)
            {
                $this->reservation->users()->syncWithoutDetaching([$user => ['total' => $this->price]]);
            }
        }

        if(!empty($this->xtrasTotal))
        {
            foreach($this->xtrasTotal as $key => $xtra)
            {
                $this->reservation->xtras()->syncWithoutDetaching([$xtra => ['total' => $this->xtrasPayment[$key]]]);
            }
        }

        if(!empty($this->toursTotal))
        {
            foreach($this->toursTotal as $key => $tour)
            {
                $this->reservation->tours()->syncWithoutDetaching([$tour => ['total' => $this->toursPayment[$key]]]);
            }
        }

        $this->resetInputs();

        session()->flash('flash.message', 'Reservación actualizada correctamente.');
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