<?php

namespace App\Livewire\Admin\Reservation;

use App\Enums\Origin;
use App\Enums\Status;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\Tour;
use App\Models\User;
use App\Models\Xtra;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

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

    public $date;
    public $room;

    #[Validate('required')]
    public $start_date;

    #[Validate('required')]
    public $end_date;
    #[validate('required')]
    public $start_time;
    #[validate('required')]
    public $end_time;
    #[Validate('required')]
    public $room_id;
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

    #[Validate(['numeric'])]
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
    public $showTimeSetting = false;

    public $showAdvanceReservation = false;
    public $numberReservation;

    // debt
    public $debtTour;
    public $debtXtra;

    // calulate debt
    public function debt()
    {
        $this->reset([
            'debtTour',
            'debtXtra',
        ]);

        foreach ($this->xtrasTotal as $key => $xtra) {
            if (empty($this->xtrasPayment[$key]['paid']) && !empty($this->xtrasPayment[$key]['price']) && is_numeric($this->xtrasPayment[$key]['price'])) {
                $this->debtXtra += (int) $this->xtrasPayment[$key]['price'] * (int) $this->xtrasPayment[$key]['amount'];
            }
        }

        foreach ($this->toursTotal as $key => $tour) {
            if (empty($this->toursPayment[$key]['paid']) && !empty($this->toursPayment[$key]['price']) && is_numeric($this->toursPayment[$key]['price'])) {
                $this->debtTour +=(int) $this->toursPayment[$key]['price'] * (int) $this->toursPayment[$key]['amount'];
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
            /*$this->reset([
                "usersTotal.$key.name",
                "usersTotal.$key.lastName",
                "usersTotal.$key.email",
                "usersTotal.$key.phone",
            ]);*/
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

        // // user find data
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
        if ($this->status == 'booking' || $this->status == 'confirmed') {
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
        $xtra = Xtra::find($idXtra);
        if (!empty($xtra)) {
            $this->xtrasPayment[$key]['price'] = $xtra->price;
            $this->xtrasPayment[$key]['amount'] = 1;
            $this->calculateTotalPrice();
        }
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
            'nights',
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
        }elseif ($this->status == 'confirmed') {
            $this->validate([
                'advance_reservation' => 'numeric',
            ]);
        }else {
            $this->advance_reservation = null;
        }

        if (!empty($this->xtrasTotal)) {
            $rules = [];
            $messages = [];
            foreach ($this->xtrasTotal as $key => $xtra) {
                $rules["xtrasTotal.$key"] = 'required|exists:xtras,id';
                $rules["xtrasPayment.$key.price"] = 'required|numeric';
                $rules["xtrasPayment.$key.amount"] = 'required|numeric';

                $messages["xtrasTotal.$key"] = 'Selecciona un extra';
                $messages["xtrasPayment.$key.price.required"] = 'Precio requerido';
                $messages["xtrasPayment.$key.amount.required"] = 'Cantidad requerida';
            }

            $this->validate($rules, $messages);
        }

        if (!empty($this->toursTotal)) {
            $rules = [];
            $messages = [];
            foreach ($this->toursTotal as $key => $tour) {
                $rules["toursTotal.$key"] = "required|exists:tours,id";
                $rules["toursPayment.$key.price"] = 'required|numeric';
                $rules["toursPayment.$key.amount"] = 'required|numeric';

                $messages["toursTotal.$key"] = 'Selecciona un tour';
                $messages["toursPayment.$key.price.required"] = 'Precio requerido';
                $messages["toursPayment.$key.amount.required"] = 'Cantidad requerida';
            }

            $this->validate($rules, $messages);
        }

        $reservation = Reservation::create([
            'entry_date' => Carbon::parse($this->start_date. ' ' . $this->start_time),
            'exit_date' => Carbon::parse($this->end_date. ' ' . $this->end_time),
            'room_id' => $this->room_id,
            'status' => $this->status,
            'origin' => $this->origin,
            'comments' => $this->comments,
            'reservation_code' => Str::uuid()->toString(),
        ]);

        RoomHistory::create([
            'room_id' => $this->room_id,
            'reservation_code' => $reservation->reservation_code,
            'status' => 'clean',
            'from' => Carbon::parse($this->start_date. ' ' . $this->start_time),
            'to' => Carbon::parse($this->end_date. ' ' . $this->end_time),
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

        foreach ($this->usersTotal as $key => $user) {
            if ($key == 0 || empty($user['document'] || empty($user['documentType']))) {
                continue;
            }

            if (!empty($user['id'])) {
                $findUser = User::where('id', $user['id'])
                    ->orWhere('document', $user['document'])
                    ->first();
                if ($findUser) {
                    $this->createWithExistingUser($reservation, $user, $findUser);
                } else {
                    $this->createWithNewUser($reservation, $user);
                }
                continue;
            }
            $this->createWithNewUser($reservation, $user);
        }

        if (!empty($this->xtrasTotal)) {
            foreach ($this->xtrasTotal as $key => $xtra) {

                $this->xtrasPayment[$key]['paid'] = !empty($this->xtrasPayment[$key]['paid']) ? $this->xtrasPayment[$key]['paid'] : 0;
                $reservation->xtras()->attach($xtra, [
                    'total' => $this->xtrasPayment[$key]['price'],
                    'amount' => $this->xtrasPayment[$key]['amount'],
                    'paid' => $this->xtrasPayment[$key]['paid']
                ]);
            }
        }

        if (!empty($this->toursTotal)) {
            foreach ($this->toursTotal as $key => $tour) {
                $this->toursPayment[$key]['paid'] = !empty($this->toursPayment[$key]['paid']) ? $this->toursPayment[$key]['paid'] : 0;
                $reservation->tours()->attach($tour, [
                    'total' => $this->toursPayment[$key]['price'],
                    'amount' => $this->toursPayment[$key]['amount'],
                    'paid' => $this->toursPayment[$key]['paid']
                ]);
            }
        }
        session()->flash('flash.message', '¡Reservación creada con éxito!');
        return redirect()->route('reservation.index');
    }

    public function mount(Room $room, $date)
    {
        $this->date = $date;
        $this->room = $room;

        $this->room_id = $room->id;
        $this->open = true;
        $this->start_date = $date->format('Y-m-d');
        $this->end_date = $date->addDay()->format('Y-m-d');
        $this->start_time = $this->start_date == now()->format('Y-m-d') ? now()->format('H:i') : '10:00';
        $this->end_time = '12:00';
        $this->price = $room->roomType->price;
        $this->roomCode = $room->code;
        $this->floor = $room->floor;
        $this->roomType = $room->roomType->description;

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
        return view('livewire.admin.reservation.create-reservation');
    }

    public function createWithNewUser($reservation, $user)
    {
        $createdUser = User::create([
            'name' => isset($user['name']) ? $user['name'] : '',
            'surname' => isset($user['lastName']) ? $user['lastName'] : '',
            'email' => isset($user['email']) ? $user['email'] : '',
            'phone' => isset($user['phone']) ? $user['phone'] : '',
            'document_type' => $user['documentType'],
            'document' => $user['document'],
            'password' => bcrypt('password'),
        ]);

        if ($this->userFavorite) {
            $createdUser->favorite = true;
        }

        $createdUser->save();

        if ($this->usersTotal[1]['document'] == $user['document']) {
            $reservation->users()->attach($createdUser->id, ['total' => $this->price, 'reserver' => true]);
            return;
        }

        $reservation->users()->attach($createdUser->id, ['total' => $this->price]);
    }

    public function createWithExistingUser($reservation, $user, $findUser)
    {
        if ($this->userFavorite) {
            $findUser->favorite = true;
        }
        $findUser->name = isset($user['name']) ? $user['name'] : $findUser->name;
        $findUser->surname = isset($user['lastName']) ? $user['lastName'] : $findUser->surname;
        $findUser->email = isset($user['email']) ? $user['email'] : $findUser->email;
        $findUser->phone = isset($user['phone']) ? $user['phone'] : $findUser->phone;
        $findUser->document_type = $user['documentType'];
        $findUser->document = $user['document'];
        $findUser->save();

        if ($this->usersTotal[1]['document'] == $findUser->document) {
            $reservation->users()->attach($findUser->id, ['total' => $this->price, 'reserver' => true]);
            return;
        }

        $reservation->users()->attach($findUser->id, ['total' => $this->price]);
    }
}
