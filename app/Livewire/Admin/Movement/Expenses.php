<?php

namespace App\Livewire\Admin\Movement;

use App\Models\Expense;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Expenses extends Component
{
    use WithPagination;
 
    public $search;
    public $date;
    public $perPage;

    protected $startDate;
    protected $endDate;

    public function getDays()
    {
        $date = Carbon::parse($this->date);
        switch ($this->perPage) {
            case 'day':
                $this->startDate = clone $date;
                $this->endDate = $date;
                break;
            case 'days':
                $this->endDate = clone $date;
                $this->startDate = $date->subDays(5);
                break;
            case 'week':
                $this->endDate = clone $date;
                $this->startDate = $date->subWeek();
                break;
            case 'month':
                $this->endDate = clone $date;
                $this->startDate = $date->subMonth();
                break;
            default:
                break;
        }
    }

    public function getDailyExpenses(Carbon $startDate,Carbon $endDate, $search)
    {
        return Expense::when($search, function ($query) use ($search) {
                $query->where('description','like','%'. $search .'%');
            })->whereBetween("created_at", [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy("created_at","desc")
            ->paginate(12);
    }

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->perPage = 'day';
    }

    #[On("refreshExpenses")]
    public function render()
    {
        $this->getDays();

        $expenses = $this->getDailyExpenses($this->startDate, $this->endDate, $this->search);
        return view('livewire.admin.movement.expenses', compact('expenses'));
    }
}
