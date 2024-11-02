<?php

namespace App\Livewire\Components\Reservation;

use Livewire\Component;

class Comment extends Component
{
    public string $comment;

    public function mount(string $comment): void
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.components.reservation.comment');
    }
}
