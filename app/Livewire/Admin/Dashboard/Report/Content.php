<?php

namespace App\Livewire\Admin\Dashboard\Report;

use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class Content extends Component
{
    public $reservationsForDay = [
        'Monday' => 0,
        'Tuesday' => 0,
        'Wednesday' => 0,
        'Thursday' => 0,
        'Friday' => 0,
        'Saturday' => 0,
        'Sunday' => 0
    ];

    public $origins = [
        'booking' => 0,
        'whatsapp' => 0,
        'llamada' => 0,
        'facebook' => 0,
        'calle' => 0,
        'hostalworld' => 0,
    ];

    public function mount()
    {
        $now = Carbon::now();
        $oneWeekAgo = $now->clone()->subDays(7);
        $reservations = Reservation::whereBetween('created_at', [$oneWeekAgo, $now])->get();

        foreach ($reservations as $reservation) {
            $day = $reservation->created_at->format('l');
            $this->reservationsForDay[$day] += 1;
            $this->origins[$reservation->origin] += 1;
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.report.content');
    }
}
