<?php

namespace App\Livewire\Components\Reservation;

use App\Models\Xtra;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Support\Str;

class Extra extends Component
{
    public array $extras;
    public Collection $extrasData;

    public function addExtra(): void
    {
        $this->extras[Str::uuid()->toString()] = [
            'id' => '',
            'price' => '',
            'quantity' => '',
            'total' => 0,
            'paid' => false,
        ];
    }

    public function setExtra(string $key): void
    {
        $this->extras[$key]['price'] = $this->extrasData->where('id', $this->extras[$key]['id'])->first()->price;
    }

    public function removeExtra(string $key): void
    {
        unset($this->extras[$key]);
    }

    public function mount(): void
    {
        $this->extrasData = Xtra::all();
    }

    public function render()
    {
        return view('livewire.components.reservation.extra');
    }
}
