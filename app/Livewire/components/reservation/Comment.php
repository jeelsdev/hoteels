<?php

namespace App\Livewire\Components\Reservation;

use Livewire\Component;

class Comment extends Component
{
    public string $comment;

    protected $listeners = ['before-save-reservation' => 'beforeSave'];

    public function beforeSave(): void
    {
        $this->validate([
            'comment' => 'string',
        ]);

        $this->dispatch('validate-saved-reservation', [
            'component' => 'comment',
            'data' => $this->comment,
        ]);
    }

    public function mount(string $comment): void
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.components.reservation.comment');
    }
}
