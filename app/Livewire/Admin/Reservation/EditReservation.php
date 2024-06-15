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

    public $roomCode;
    public $floor;
    public $roomType;

    #[Validate('required')]
    public $origin;

    #[Validate('required')]
    public $status;

    // Summaries
    #[Validate('required')]
    public $total_reservation = 0;
    public $total_xtras = 0;
    public $total_tours = 0;

    #[Validate(['numeric', 'regex:/^\d+$/'])]
    public $price;

    public $comments;
    public $pending_payment;
    public $advance_reservation;
    public $advance_xtras;
    public $advance_tours;
    public $usersTotal = [1 => []];
    public $xtrasTotal = [];
    public $toursTotal = [];

    public $inputXtras = [];
    public $inputTours = [];

    public $xtrasPayment = [];
    public $toursPayment = [];

    public $uI = 1;
    public $tI = 0;
    public $xI = 0;
    public $userFavorite = false;
    public $isFavorite = false;
    public $createWithNewUser = false;

    public $showUser = 1;
    public $showRoom = false;

    public $showAdvanceReservation = false;
    public $numberReservation;

    // debt
    public $debtTour;
    public $debtXtra;

    // reservation
    public $reservation;

    // user
    public $user;

    // room
    public $room;

    // calulate debt
    public function debt()
    {
        $this->reset([
            'debtTour',
            'debtXtra',
        ]);

        foreach ($this->xtrasTotal as $key => $xtra) {
            if (empty($this->xtrasPayment[$key]['paid']) && !empty($this->xtrasPayment[$key]['price'])) {
                $this->debtXtra += $this->xtrasPayment[$key]['price'] * $this->xtrasPayment[$key]['amount'];
            }
        }

        foreach ($this->toursTotal as $key => $tour) {
            if (empty($this->toursPayment[$key]['paid']) && !empty($this->toursPayment[$key]['price'])) {
                $this->debtTour += $this->toursPayment[$key]['price'] * $this->toursPayment[$key]['amount'];
            }
        }
    }

    // calulate nights
    public $nights;

    public function findUser($key)
    {
        $this->validate([
            "usersTotal.$key.document" => "required",
        ]);

        $user = User::where('document', $this->usersTotal[$key]['document'])
            ->first();

        if (!isset($user)) {
            $this->reset([
                "usersTotal.$key.name",
                "usersTotal.$key.lastName",
                "usersTotal.$key.email",
                "usersTotal.$key.phone",
                "usersTotal.$key.documentType",
            ]);
            $this->addError("usersTotal.$key.document", "Usuario no encontrado");
            return;
        }

        $this->usersTotal[$key] = [
            'id' => $user->id,
            'name' => $user->name,
            'lastName' => $user->surname,
            'email' => $user->email,
            'phone' => $user->phone,
            'documentType' => $user->document_type,
            'document' => $user->document,
        ];
    }

    public function showUserForKey($keyUser)
    {
        $this->showUser = $keyUser;
    }

    public function showCreateWithNewUser()
    {
        $this->createWithNewUser = true;
        $this->usersTotal[0] = null;
        $this->uI = 1;
    }

    public function isFavoriteUser()
    {
        if ($this->usersTotal[0]) {
            $user = User::find($this->usersTotal[0]);
            $this->isFavorite = true;
            $this->userFavorite = $user->favorite;
        } else {
            $this->isFavorite = false;
        }

        // user find data
        // $this->user = User::find($this->usersTotal[0]);
        // $this->documentType = $this->user->document_type;
        // $this->document = $this->user->document;
    }

    public function addFavoriteUser()
    {
        $this->userFavorite ? $this->userFavorite = false : $this->userFavorite = true;
    }

    public function checkStatusPending()
    {
        if ($this->status == 'booking') {
            $this->showAdvanceReservation = true;
        } else {
            $this->showAdvanceReservation = false;
        }
    }

    public function addUser($i)
    {
        $i = $i + 1;
        $this->uI = $i;
        $this->showUser = $i;
        array_push($this->usersTotal, [$i]);
    }

    public function removeUserTotal($key)
    {
        unset($this->usersTotal[$key]);
        $this->uI = $this->uI - 1;
        $this->showUser = 1;
        // reordenar usersTotal desde su indice 1
        $this->usersTotal = array_combine(range(1, count($this->usersTotal)), array_values($this->usersTotal));
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
        $this->xtrasPayment[$key]['price'] = Xtra::find($idXtra)->price;
        $this->xtrasPayment[$key]['amount'] = 1;
        $this->calculateTotalPrice();
    }

    // calculate total price
    public function calculateTotalPrice()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $this->nights = $start->diffInDays($end);

        if (!empty($this->xtrasPayment)) {
            $totalPrice = 0;
            foreach ($this->xtrasPayment as $xtra) {
                if (!empty($xtra['amount']) && !empty($xtra['price'])) {
                    $totalPrice += $xtra['amount'] * $xtra['price'];
                }
            }
            $this->total_xtras = $totalPrice;
        } else {
            $this->total_xtras = 0;
        }

        if (!empty($this->toursTotal) && !empty($this->toursPayment)) {
            $totalPrice = 0;
            foreach ($this->toursPayment as $tour) {
                if (!empty($tour['amount']) && !empty($tour['price'])) {
                    $totalPrice += $tour['amount'] * $tour['price'];
                }
            }
            $this->total_tours = $totalPrice;
        } else {
            $this->total_tours = 0;
        }

        if (is_numeric($this->price) && $this->price >= 0) {
            $this->total_reservation = $this->nights * $this->price;
        }

        // calculate pending payment
        if (is_numeric($this->advance_reservation) && $this->advance_reservation > 0 && $this->advance_reservation <= $this->total_reservation) {
            $this->pending_payment = $this->total_reservation - $this->advance_reservation;
        } else {
            $this->pending_payment = $this->total_reservation;
        }

        $this->debt();
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
            'origin',
            'status',
            'total_reservation',
            'total_xtras',
            'total_tours',
            'price',
            'comments',
            'advance_reservation',
            'advance_xtras',
            'advance_tours',
            'usersTotal',
            'xtrasTotal',
            'toursTotal',
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
            'showUser',
            'showRoom',
            'showAdvanceReservation',
            'numberReservation',
            'debtTour',
            'debtXtra',
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->validate([
            'usersTotal.1.name' => 'required',
            'usersTotal.1.documentType' => 'required',
            'usersTotal.1.document' => 'required'
        ]);

        if ($this->status == 'booking') {
            $this->validate([
                'advance_reservation' => 'required|numeric',
            ]);
        } else {
            $this->advance_reservation = null;
        }
        $this->reservation->entry_date = $this->start_date;
        $this->reservation->exit_date = $this->end_date;
        $this->reservation->room_id = $this->room->id;
        $this->reservation->status = $this->status;
        $this->reservation->origin = $this->origin;
        $this->reservation->comments = $this->comments;

        $this->reservation->save();

        $payment = Payment::where('reservation_id', $this->reservation->id)->first();
        $payment->total_reservation = $this->total_reservation;
        $payment->total_xtras = $this->total_xtras;
        $payment->total_tours = $this->total_tours;
        $payment->advance_reservation = $this->advance_reservation;
        $payment->advance_xtras = $this->advance_xtras;
        $payment->advance_tours = $this->advance_tours;
        $payment->type = 'CASH';
        $payment->save();
        
        $this->reservation->users()->detach();
        foreach ($this->usersTotal as $key => $user) {
            if ($key == 0) {
                continue;
            }

            if (!empty($user['id'])) {
                $findUser = User::where('id', $user['id'])
                    ->orWhere('document', $user['document'])
                    ->first();
                if ($findUser) {
                    $this->createWithExistingUser($user, $findUser);
                } else {
                    $this->createWithNewUser($user);
                }
                continue;
            }
            $this->createWithNewUser($user);
        }

        if (!empty($this->xtrasTotal)) {
            $this->reservation->xtras()->detach();
            foreach ($this->xtrasTotal as $key => $xtra) {

                $this->xtrasPayment[$key]['paid'] = !empty($this->xtrasPayment[$key]['paid']) ? $this->xtrasPayment[$key]['paid'] : 0;

                $this->reservation->xtras()->attach([$xtra => [
                    'total' => $this->xtrasPayment[$key]['price'],
                    'amount' => $this->xtrasPayment[$key]['amount'],
                    'paid' => $this->xtrasPayment[$key]['paid']
                ]]);
            }
        }

        if (!empty($this->toursTotal)) {
            $this->reservation->tours()->detach();
            foreach ($this->toursTotal as $key => $tour) {
                $this->toursPayment[$key]['paid'] = !empty($this->toursPayment[$key]['paid']) ? $this->toursPayment[$key]['paid'] : 0;
                $this->reservation->tours()->attach([$tour => [
                    'total' => $this->toursPayment[$key]['price'],
                    'amount' => $this->toursPayment[$key]['amount'],
                    'paid' => $this->toursPayment[$key]['paid']
                ]]);
            }
        }

        $this->resetInputs();

        session()->flash('flash.message', '¡Reservación actualizada correctamente!');

        return redirect()->route('reservation.index');
    }

    public function mount($data)
    {
        // Parse the URL and get the query part
        $urlParts = parse_url($data);
        $query = $urlParts['path'];
        
        // Replace '&amp;' with '&'
        $query = str_replace('&amp;', '&', $query);
        
        parse_str($query, $data);
        try {
            $dateStart = Carbon::parse($data['start']);
            $dateEnd = Carbon::parse($data['end']);
            $this->room = Room::findOrFail($data['resource']);
            $this->reservation = Reservation::findOrFail($data['reservation']);
        } catch (\Throwable $th) {
            session()->flash('flash.message', '¡No se encontró la reservación!');
            return redirect()->route('reservation.index');
        }

        // reservation data
        $this->numberReservation = $this->reservation->id;
        $this->start_date = $dateStart->format('Y-m-d');
        $this->end_date = $dateEnd->format('Y-m-d');
        $this->origin = $this->reservation->origin;

        if($this->reservation->users->isEmpty())
        {
            session()->flash('flash.message', '¡Ops! Ocurrio un error al cargar el huesped');
            return redirect()->route('reservation.index');
        }

        $reservationUser = $this->reservation->users->first();

        // room data
        $this->roomType = $this->room->roomType->description;
        $this->floor = $this->room->floor;
        $this->price = $reservationUser->pivot->total;
        $this->roomCode = $this->room->code;

        // user data
        $this->usersTotal[1] = [
            'id' => $reservationUser->id,
            'name' => $reservationUser->name,
            'lastName' => $reservationUser->surname,
            'email' => $reservationUser->email,
            'phone' => $reservationUser->phone,
            'documentType' => $reservationUser->document_type,
            'document' => $reservationUser->document,
        ];
        foreach ($this->reservation->users as $key => $user) {
            if ($key == 0) {
                continue;
            }
            $key = $key + 1;
            $this->usersTotal[$key] = [
                'id' => $user->id,
                'name' => $user->name,
                'lastName' => $user->surname,
                'email' => $user->email,
                'phone' => $user->phone,
                'documentType' => $user->document_type,
                'document' => $user->document,
            ];
        }

        // Xtras
        if ($this->reservation->xtras) {
            foreach ($this->reservation->xtras as $key => $xtra) {
                $plus = $key + 1;
                $this->xtrasTotal["$key$plus"] = $xtra->pivot->xtra_id;
                $this->xtrasPayment["$key$plus"]['price'] = $xtra->pivot->total;
                $this->xtrasPayment["$key$plus"]['amount'] = $xtra->pivot->amount;
                $this->xtrasPayment["$key$plus"]['paid'] = $xtra->pivot->paid ? true : false;
                array_push($this->inputXtras, $plus);
            }
            $this->xI = count($this->inputXtras);
        } else {
            $this->xI = 0;
            $this->inputXtras = [];
        }

        // Tours
        if ($this->reservation->tours) {
            foreach ($this->reservation->tours as $key => $tour) {
                $plus = $key + 1;
                $this->toursTotal["$key$plus"] = $tour->pivot->tour_id;
                $this->toursPayment["$key$plus"]['price'] = $tour->pivot->total;
                $this->toursPayment["$key$plus"]['amount'] = $tour->pivot->amount;
                $this->toursPayment["$key$plus"]['paid'] = $tour->pivot->paid ? true : false;
                array_push($this->inputTours, $plus);
            }
            $this->tI = count($this->inputTours);
        } else {
            $this->tI = 0;
            $this->inputTours = [];
        }

        // status
        $this->status = $this->reservation->status;
        if ($this->status == 'booking') {
            $this->showAdvanceReservation = true;
            $this->advance_reservation = $this->reservation->payment->advance_reservation;
        }

        // comments
        $this->comments = $this->reservation->comments;

        $this->calculateTotalPrice();
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

    public function createWithNewUser($user)
    {
        $createdUser = User::create([
            'name' => $user['name'],
            'surname' => $user['lastName'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'document_type' => $user['documentType'],
            'document' => $user['document'],
            'password' => bcrypt('password'),
        ]);

        if ($this->userFavorite) {
            $createdUser->favorite = true;
        }

        $createdUser->save();

        if ($this->usersTotal[1]['document'] == $user['document']) {
            $this->reservation->users()->attach($createdUser->id, ['total' => $this->price, 'reserver' => true]);
            return;
        }

        $this->reservation->users()->attach($createdUser->id, ['total' => $this->price]);
    }

    public function createWithExistingUser($user, $findUser)
    {
        if ($this->userFavorite) {
            $findUser->favorite = true;
        }
        $findUser->name = $user['name'];
        $findUser->surname = $user['lastName'];
        $findUser->email = $user['email'];
        $findUser->phone = $user['phone'];
        $findUser->document_type = $user['documentType'];
        $findUser->document = $user['document'];
        $findUser->save();

        if ($this->usersTotal[1]['id'] == $findUser->id) {
            $this->reservation->users()->attach($findUser->id, ['total' => $this->price, 'reserver' => true]);
            return;
        }

        $this->reservation->users()->attach($findUser->id, ['total' => $this->price]);
    }
}
