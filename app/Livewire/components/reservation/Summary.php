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

    public int $price;

    protected $listeners = [
        'before-save-reservation' => 'beforeSave',
        'date-time-updated-nights' => 'setNights',
        'status-updated-r-debt' => 'setRDebt',
        'update-summary-extras' => 'setExtras',
        'update-summary-e-debt' => 'setEDebt',
        'update-summary-e-total' => 'setETotal',
        'update-summary-tours' => 'setTours',
        'update-summary-t-total' => 'setTTotal',
        'update-summary-t-debt' => 'setTDebt',
        'room-updated-price' => 'setPrice',
    ];

    public function beforeSave(): void
    {
        $this->dispatch('validate-saved-reservation', [
            'component' => 'summary',
            'data' => [
                'total' => $this->totalTotal,
            ],
        ]);
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;

        $this->setRTotal($price);
    }

    public function setExtras(int $extras): void
    {
        $this->extras = $extras;

        $this->updateTotal();
    }

    public function setEDebt(int $debt): void
    {
        $this->eDebt = $debt;

        $this->updateTotal();
    }

    public function setETotal(int $price): void
    {
        $this->eTotal = $price;

        $this->updateTotal();
    }

    public function setTDebt(int $debt): void
    {
        $this->tDebt = $debt;

        $this->updateTotal();
    }

    public function setTours(int $tours): void
    {
        $this->tours = $tours;

        $this->updateTotal();
    }

    public function setRDebt(int $debt): void
    {
        $this->rDebt = $debt;

        $this->updateTotal();
    }

    public function setTTotal(int $price): void
    {
        $this->tTotal = $price;

        $this->updateTotal();
    }

    public function setRTotal(int $price): void
    {
        $this->rTotal = $price * $this->nights;

        $this->dispatch('summary-updated-r-total', $this->rTotal);

        $this->updateTotal();
    }

    public function setNights(int $nights): void
    {
        $this->nights = $nights;

        $this->setRTotal($this->price);

        $this->updateTotal();
    }

    public function updateTotal(): void
    {
        $this->totalTotal = $this->rTotal + $this->eTotal + $this->tTotal;

        $this->totalDebt = $this->rDebt + $this->eDebt + $this->tDebt;

        $this->dispatch('update-status-total', $this->totalTotal);
    }

    public function mount(int $nights, int $rTotal, int $rDebt, int $extras, int $eDebt, int $eTotal, int $tours, int $tDebt, int $tTotal, int $price): void
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
        $this->price = $price;

        $this->updateTotal();
    }

    public function render()
    {
        return view('livewire.components.reservation.summary');
    }
}
