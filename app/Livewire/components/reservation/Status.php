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

        $this->setPending();
    }

    public function setPending(): void
    {
        $this->pending = $this->total - $this->advance;
    }

    public function setShow(): void
    {
        if ($this->status == 'booking' || $this->status == 'confirmed') {
            $this->show = true;
            return;
        }

        $this->show = false;
    }

    public function mount(int $total, int $advance, bool $show): void
    {
        $this->enumsStatus = EnumsStatus::getArrayValues();
        $this->total = $total;
        $this->advance = $advance;
        $this->show = $show;
        $this->setPending();
    }

    public function render()
    {
        return view('livewire.components.reservation.status');
    }
}
