<?php

namespace App\Livewire\Admin\Movement\Expense;

use App\Models\Expense;
use Carbon\Carbon;
use Livewire\Component;

class Information extends Component
{
    public $date;
    public $dayRange;
    public $startDay;
    public $endDay;

    public $totalExpenses;
    public $expenses = [];
    public function generateDateRange()
    {
        if($this->dayRange == 'day' || $this->dayRange == 'week')
        {
            return collect([
                '0'=>0,
                '1'=>0,
                '2'=>0,
                '3'=>0,
                '4'=>0,
                '5'=>0,
                '6'=>0
            ]);
        }else{
            return collect([
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
                '9' => 0,
                '10' => 0,
                '11' => 0,
                '12' => 0
            ]);
        }
    }

    public function getData($start, $end)
    {
        if($this->dayRange == 'week')
        {
            return Expense::whereBetween('created_at', [$start, $end])
                ->selectRaw('DAYOFWEEK(created_at) as day, SUM(amount) as amount')
                ->groupBy('day')
                ->get();
        }
        return Expense::whereBetween('created_at', [$start, $end])
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as amount')
            ->groupBy('month')
            ->get();
    }

    public function getDays()
    {
        $date = Carbon::parse($this->date);
        switch ($this->dayRange){
            case 'month':
                $this->startDay = $date->startOfMonth()->format('Y-m-d');
                $this->endDay = $date->endOfMonth()->format('Y-m-d');
                break;
            case 'year':
                $this->startDay = $date->startOfYear()->format('Y-m-d');
                $this->endDay = $date->endOfYear()->format('Y-m-d');
                break;
            default:
                $this->startDay = $date->startOfWeek()->format('Y-m-d');
                $this->endDay = $date->endOfWeek()->format('Y-m-d');
                break;
        }
        $data = $this->getData($this->startDay, $this->endDay);
        $dates = $this->generateDateRange();
        
        $expenses = $dates->map(function ($date, $key) use ($data){
            if($this->dayRange == 'day' || $this->dayRange == 'week')
            {
                $day = $data->where('day', $key)->first();
                return $day ? $day->amount : 0;
            }
            $month = $data->where('month', $key)->first();
            return $month ? $month->amount : 0;
        });

        if($this->dayRange == 'day')
        {
            $this->totalExpenses = $expenses->get($date->weekday());
            $this->expenses = $expenses;
            return;
        }

        $this->totalExpenses = $expenses->sum();
        $this->expenses = $expenses;
    }

    public function mount()
    {
        $this->date = date("Y-m-d", strtotime("now"));
        $this->dayRange = 'month';
        $this->getDays();
    }

    public function render()
    {
        return view('livewire.admin.movement.expense.information');
    }
}
