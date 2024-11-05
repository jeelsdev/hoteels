<?php

namespace App\Livewire\Components\Reservation;

use App\Enums\Origin;
use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DateTime extends Component
{
    #[Validate('required', 'date')]
    public String $startDate;

    #[Validate('required', 'date')]
    public String $endDate;

    #[Validate('required', 'date')]
    public String $startTime;

    #[Validate('required', 'date')]
    public String $endTime;

    public array $origins;

    public int $numberReservation;

    public int $nights;

    public bool $showTimeSetting = false;

    public string $origin;

    protected $listeners = ['before-save-reservation' => 'beforeSave'];

    public function beforeSave(): void
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'origin' => 'required|string',
            'startTime' => 'required',
            'endTime' => 'required',
        ]);

        $this->dispatch('validate-saved-reservation', [
            'component' => 'date-time',
            'data' => [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'origin' => $this->origin,
                'startTime' => $this->startTime,
                'endTime' => $this->endTime,
                'night' => $this->nights,
            ],
        ]);
    }

    public function calculate(): void
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        $this->nights = $start->diffInDays($end);

        $this->dispatch('update-summary-nights', $this->nights);
    }

    public function mount(Carbon $date)
    {
        $this->origins = Origin::getArrayValues();
        $this->startDate = $date->format('Y-m-d');
        $this->endDate = $date->addDays(1)->format('Y-m-d');
        $this->startTime = $date == now()->format('Y-m-d') ? now()->format('H:i') : '10:00';
        $this->endTime = '12:00';
        $this->numberReservation = Reservation::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count() + 1;
        $this->nights = 1;
    }

    public function render()
    {
        return view('livewire.components.reservation.date-time');
    }
}
