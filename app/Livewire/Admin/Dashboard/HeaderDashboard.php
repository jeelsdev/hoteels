<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Reservation;
use App\Models\User;
use Livewire\Component;

class HeaderDashboard extends Component
{
    public $totalSales;
    public $totalReservations;
    public $totalNewUsers;
    public $profits;
    
    public function render()
    {
        $reservations = new Reservation();
        $users = new User();
        $this->totalSales = $reservations->totalSales();
        $this->totalReservations = $reservations->totalReservations();
        $this->profits = $reservations->profits();
        $this->totalNewUsers = $users->newUsers();
        
        return view('livewire.admin.dashboard.header-dashboard');
    }
}
