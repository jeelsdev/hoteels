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

    public int $pending;

    public bool $show;

    protected $listeners = [
        'before-save-reservation' => 'beforeSave',
        'update-status-total' => 'setTotal',
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

    public function setTotal(int $total): void
    {
        $this->total = $total;
        $this->pending = $total - ( $this->advance ?? 0 );
    }

    public function setPending(): void
    {
        $this->pending = $this->total - ( $this->advance ?? 0 );

        $this->dispatch('update-summary-r-debt', $this->pending);
    }

    public function setShow(): void
    {
        if($this->status == 'confirmed') {
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
        $this->pending = $total - $advance;
    }

    public function render()
    {
        return view('livewire.components.reservation.status');
    }
}
