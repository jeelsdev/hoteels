<?php

namespace App\Livewire\Admin\Movement;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $income;
    public $expenses;
    public $dayRange;
    public $startStringRangeDate;
    public $endStringRangeDate;
    protected $chartData = [];

    public function getDays()
    {
        Carbon::setLocale('es');
        $this->getIncome();
        $this->getExpenses();
        
        if ($this->dayRange == 'week') {
            $this->startStringRangeDate = now()->startOfWeek()->isoFormat('dddd D MMMM');
            $this->endStringRangeDate = now()->endOfWeek()->isoFormat('dddd D MMMM');
            $this->dispatch('panelCharts', ['data' => $this->getChartDataWeek(), 'dayRange' => $this->dayRange]);
        }else{
            $this->startStringRangeDate = now()->startOfMonth()->isoFormat('dddd D MMMM');
            $this->endStringRangeDate = now()->endOfMonth()->isoFormat('dddd D MMMM');
            $this->dispatch('panelCharts', ['data' => $this->getChartDataMonths(), 'dayRange' => $this->dayRange]);
        }
    }

    public function getChartDataWeek()
    {
        $expenseData = Expense::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('sum(amount) as total, DAYOFWEEK(created_at) as day')
            ->groupBy('day')
            ->get()
            ->keyBy('day');
        $reservationsData = Payment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('sum(total_reservation) as total, DAYOFWEEK(created_at) as day')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $days = [];
        for ($i = 1; $i <= 7; $i++) {
            $days['expenses'][$i] = $expenseData[$i]->total??0;
            $days['income'][$i] = $reservationsData[$i]->total??0;
        }
        return $days;
    }

    public function getChartDataMonths()
    {
        $expensesData = Expense::whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->selectRaw('sum(amount) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->get()
            ->keyBy('month');
        $reservationsData = Payment::whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])
            ->selectRaw('sum(total_reservation) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months['expenses'][$i] = $expensesData[$i]->total??0;
            $months['income'][$i] = $reservationsData[$i]->total??0;
        }
        return $months;
    }

    protected function getExpenses()
    {
        if ($this->dayRange == 'week') {
            $this->expenses = Expense::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->selectRaw('sum(amount) as total')
                ->get();
        }else{
            $this->expenses = Expense::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->selectRaw('sum(amount) as total')
                ->get();
        }
    }
    protected function getIncome()
    {
        if ($this->dayRange == 'week') {
            $this->income = Payment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->selectRaw('sum(total_reservation) as total')
                ->get('total');
        }else{
            $this->income = Payment::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->selectRaw('sum(total_reservation) as total')
                ->get();
        }
    }

    public function mount()
    {
        $this->dayRange = 'week';
        $this->getExpenses();
        $this->getIncome();
        $this->getDays();
    }

    public function render()
    {
        return view('livewire.admin.movement.index');
    }
}
