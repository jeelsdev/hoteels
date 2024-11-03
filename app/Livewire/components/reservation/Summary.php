<?php

namespace App\Livewire\Components\Reservation;

use Livewire\Component;

class Summary extends Component
{
    public int $nights;

    public int $rTotal;

    public int $rDebt;

    public int $extras;

    public int $eDebt;

    public int $eTotal;

    public int $tours;

    public int $tDebt;

    public int $tTotal;

    public int $totalDebt;

    public int $totalTotal;

    protected $listeners = ['update-summary-nights' => 'updateNights'];

    public function updateNights(int $nights): void
    {
        $this->nights = $nights;
    }

    public function updateTotal(): void
    {
        $this->totalTotal = $this->rTotal + $this->eTotal + $this->tTotal;

        $this->totalDebt = $this->rDebt + $this->eDebt + $this->tDebt;
    }

    public function mount(int $nights, int $rTotal, int $rDebt, int $extras, int $eDebt, int $eTotal, int $tours, int $tDebt, int $tTotal)
    {
        $this->nights = $nights;
        $this->rTotal = $rTotal;
        $this->rDebt = $rDebt;
        $this->extras = $extras;
        $this->eDebt = $eDebt;
        $this->eTotal = $eTotal;
        $this->tours = $tours;
        $this->tDebt = $tDebt;
        $this->tTotal = $tTotal;

        $this->updateTotal();
    }

    public function render()
    {
        return view('livewire.components.reservation.summary');
    }
}
