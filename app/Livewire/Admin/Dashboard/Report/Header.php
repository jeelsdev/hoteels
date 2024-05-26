<?php

namespace App\Livewire\Admin\Dashboard\Report;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Livewire\Component;

class Header extends Component
{
    public $totalSales;
    public $totalReservations;
    public $totalNewUsers;
    public $profits;

    // calculate the total sales, total reservations, profits, and total new users
    public $sales;
    public $earnings;
    public $newUsers;
    public $reservations;

    public function calculatePorcentage($current, $previous)
    {
        $previous = 40;
        if($previous == 0)
        {
            return 100;
        }
        $total = $current + $previous;
        $diference = $total - $previous;
        return round(($diference*100)/$total);
    }

    public function getData()
    {
        $reservations = new Reservation();
        $users = new User();
        $payments = new Payment();
        
        $this->totalSales = $reservations->totalSales();
        $this->totalReservations = $reservations->totalReservations();
        $this->profits = $reservations->profits();
        $this->totalNewUsers = $users->newUsers();

        $this->sales = $this->calculatePorcentage($payments->salesFromCurrentDay(), $payments->salesFromPreviousDay());
        $this->earnings = $this->calculatePorcentage($payments->earningsFromCurrentDay(), $payments->earningsFromPreviousDay());
        $this->newUsers = $this->calculatePorcentage($users->newUsersFromCurrentDay(), $users->newUsersFromPreviousDay());
        $this->reservations = $this->calculatePorcentage($reservations->reservationsFromCurrentDay(), $reservations->reservationsFromPreviousDay());
    }

    public function mount()
    {
        $this->getData();

        $this->sales = number_format($this->sales, 2);
        $this->earnings = number_format($this->earnings, 2);
        $this->reservations = number_format($this->reservations, 2);
        $this->newUsers = number_format($this->newUsers, 2);
        //dd($this->sales, $this->earnings, $this->reservations, $this->newUsers);
    }

    public function render()
    {
        return view('livewire.admin.dashboard.report.header');
    }
}
