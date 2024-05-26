<?php

namespace App\Livewire\Admin\Movement\Expense;

use Livewire\Component;

class Information extends Component
{
    public $date;
    public $perDay;
    public $startDay;
    public $endDay;

    public function getDays()
    {

    }

    public function mount()
    {
        $this->date = date("Y-m-d", strtotime("now"));
    }

    public function render()
    {
        return view('livewire.admin.movement.expense.information');
    }
}
