<?php

namespace App\Livewire\Admin\Dashboard\Report;

use App\Models\Reservation;
use App\Models\Xtra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Content extends Component
{
    public $reservationForMonth = [
        'January' => 0,
        'February' => 0,
        'March' => 0,
        'April' => 0,
        'May' => 0,
        'June' => 0,
        'July' => 0,
        'August' => 0,
        'September' => 0,
        'October' => 0,
        'November' => 0,
        'December' => 0
    ];
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

    public $soldProducts;

    public function getSoldProducts()
    {
        $this->soldProducts = DB::table('reservation_xtra')
            ->join('xtras', 'reservation_xtra.xtra_id', '=', 'xtras.id')
            ->select('xtras.name as productName','xtra_id', DB::raw('count(*) as total'))
            ->groupBy('xtra_id', 'productName')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

    }
    public function getReservationForMonth()
    {
        $now = Carbon::now();
        $oneYearAgo = $now->clone()->subYear();
        $reservations = Reservation::whereBetween('created_at', [$oneYearAgo, $now])->get();

        foreach ($reservations as $reservation) {
            $month = $reservation->created_at->format('F');
            $this->reservationForMonth[$month] += 1;
        }
    }

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
        $this->getSoldProducts();
        $this->getReservationForMonth();
        $this->dispatch('pieChartProducts', ['products' => $this->soldProducts]);
        $this->dispatch('barChartPanelMonth', ['reservations' => $this->reservationForMonth]);
    }

    public function render()
    {
        return view('livewire.admin.dashboard.report.content');
    }
}
