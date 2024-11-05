<?php

namespace App\Livewire\Components\Reservation;

use App\Enums\Status as EnumsStatus;
use Livewire\Component;

class Status extends Component
{
    public array $enumsStatus;

    public string $status;

    public int $total;

    public int $advance;

    public int $rDebt;

    public bool $show;

    protected $listeners = [
        'before-save-reservation' => 'beforeSave',
        'summary-updated-r-total' => 'updatedTotal',
    ];

    public function beforeSave(): void
    {
        $this->validate([
            'status' => 'required|in:booking,confirmed,cancelled',
        ]);

        $this->dispatch('validate-saved-reservation', [
            'component' => 'status',
            'data' => [
                'status' => $this->status,
                'advance' => $this->advance,
            ],
        ]);
    }

    public function updatedTotal(int $total): void
    {
        $this->total = $total;
        $this->rDebt = $total - ( $this->advance ?? 0 );
    }

    public function updatedAdvance(): void
    {
        $this->updatedRDebt();
    }

    public function updatedRDebt(): void
    {
        $this->rDebt = $this->total - ( $this->advance ?? 0 );

        $this->dispatch('status-updated-r-debt', $this->rDebt);
    }

    public function updatedStatus(): void
    {
        if($this->status == 'canceled') {
            $this->show = false;
            return;
        }

        $this->show = true;
    }

    public function mount(int $total, int $advance, bool $show, string $status): void
    {
        $this->enumsStatus = EnumsStatus::getArrayValues();
        $this->total = $total;
        $this->advance = $advance;
        $this->show = $show;
        $this->status = $status;
        $this->rDebt = $total - $advance;
    }

    public function render()
    {
        return view('livewire.components.reservation.status');
    }
}
