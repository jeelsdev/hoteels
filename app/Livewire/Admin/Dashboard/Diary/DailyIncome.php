<?php

namespace App\Livewire\Admin\Dashboard\Diary;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class DailyIncome extends Component
{
    public $dayRange = 'days';
    public $date;
    public $startDate;
    public $endDate;

    public $dailyIncome;

    public function daysRange()
    {
        Carbon::setLocale('es');
        $date = Carbon::parse($this->date);
        switch ($this->dayRange) {
            case 'days':
                $this->endDate = clone $date;
                $this->startDate = $date->subDays(5);
                break;
            case 'week':
                $this->endDate = clone $date;
                $this->startDate = $date->subWeek();
                break;
            case 'two-weeks':
                $this->endDate = clone $date;
                $this->startDate = $date->subWeeks(2);
                break;
            case 'month':
                $this->endDate = clone $date;
                $this->startDate = $date->subMonth();
                break;
            default:
                $this->endDate = clone $date;
                $this->startDate = $date->subDays(5);
                break;
        }
        
        $this->getDailyIncome($this->startDate, $this->endDate);
    }

    protected function generateDateRange(Carbon $start,Carbon $end)
    {
        $dates = collect();
        $date = $end;
        while ($date > $start) {
            $dates->push($date->format('Y-m-d'));
            $date->subDay();
        }
        return $dates;
    }

    protected function getDailyIncome($start, $end)
    {
        $payments = Payment::whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
            ->selectRaw('DATE(created_at) as date, sum(total_reservation) as total')
            ->groupBy('date')
            ->get()
            ->keyBy('date');
        // generate date range
        $dates = $this->generateDateRange($start, $end);

        // merge payments with date range
        $dailyIncome = $dates->map(function ($date) use ($payments) {
            $dateC = Carbon::parse($date);
            return [
                'date' => $dateC->isoFormat('ddd D MMM YYYY'),
                'total' => $payments->get($date, ['total' => 0])['total'],
                'close' => $dateC->toDateString() >= Carbon::now()->toDateString() ? false : true,
            ];
        });
        $this->dailyIncome = $dailyIncome;
    }

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
        $this->daysRange();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.diary.daily-income');
    }
}
