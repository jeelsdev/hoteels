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
                if($xtra->pivot->paid != 1)
                {
                    $totalXtras += $xtra->pivot->total;
                }
            });
            $reservation->tours->each(function($tour) use (&$totalTours){
                if($tour->pivot->paid != 1)
                {
                    $totalTours += $tour->pivot->total;
                }
            });

            $user = $reservation->users->map(function($user){
                if($user->pivot->reserver == 1)
                {
                    return $user->name;
                }
            });

            $pending_reservation = 0;
            if($reservation->status == 'booking')
            {
                $pending_reservation = $reservation->payment->total_reservation-$reservation->payment->advance_reservation;
            }

            $totalTours = $totalTours??0;
            $totalXtras = $totalXtras??0;

            $total = $pending_reservation+$totalTours+$totalXtras;

            return [
                'date' => $reservation->created_at->format('d-m-Y'),
                'code'=> "#".$reservation->id.$reservation->room_id,
                'httpData' => $this->httpData($reservation->entry_date, $reservation->exit_date, $reservation->room_id, $reservation->id),
                'user' => $user->first()?$user->first():'Jose huesped',
                'booking' => $pending_reservation?$pending_reservation:'',
                'xtra' => $totalXtras?$totalXtras:'',
                'tour' => $totalTours?$totalTours:'',
                'total' => $total,
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
