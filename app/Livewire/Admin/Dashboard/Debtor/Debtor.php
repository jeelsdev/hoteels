<?php

namespace App\Livewire\Admin\Dashboard\Debtor;

use App\Models\Reservation;
use Livewire\Component;

class Debtor extends Component
{
    public $debtLists = [];

    public function httpData($start, $end, $resource, $reservation)
    {
        $data = [
            'start' => $start,
            'end'=> $end,
            'resource'=> $resource,
            'reservation'=> $reservation
        ];
        return http_build_query($data);
    }

    protected function getDebtors()
    {
        $reservationWithPivot = Reservation::whereHas('xtras', function($query){
            $query->where('paid','0');
            })->orWhereHas('tours', function($query){
                $query->where('paid','0');
            })->orWhere('status','booking')
            ->with([
            'users' => function($query){
                $query->wherePivot('reserver','1');
            },
            'payment',
            'xtras',
            'tours'])->get();
        
        $this->debtLists = $reservationWithPivot->map(function($reservation){
            $totalXtras = null;
            $totalTours = null;

            $reservation->xtras->each(function($xtra) use (&$totalXtras){
                $totalXtras += $xtra->pivot->total;
            });
            $reservation->tours->each(function($tour) use (&$totalTours){
                $totalTours += $tour->pivot->total;
            });

            $user = $reservation->users->map(function($user){
                if($user->pivot->reserver == 1)
                {
                    return $user->name;
                }
            });

            return [
                'date' => $reservation->created_at->format('d-m-Y'),
                'code'=> "#".$reservation->id.$reservation->room_id,
                'httpData' => $this->httpData($reservation->entry_date, $reservation->exit_date, $reservation->room_id, $reservation->id),
                'user' => $user->first()?$user->first():'Jose huesped',
                'booking' => $reservation->status == 'booking'?$reservation->payment->total_reservation-$reservation->payment->advance_reservation:'',
                'xtra' => $totalXtras?$totalXtras:'',
                'tour' => $totalTours?$totalTours:'',
                'total' => $reservation->payment->total_reservation,
            ];
        });
    }

    public function mount()
    {
        $this->getDebtors();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.debtor.debtor');
    }
}
