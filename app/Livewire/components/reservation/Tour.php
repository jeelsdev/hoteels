<?php

namespace App\Livewire\Components\Reservation;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Tour as TourModel;
use Illuminate\Database\Eloquent\Collection;

class Tour extends Component
{
    public array $tours;
    public Collection $toursData;

    public function setTour(string $key): void
    {
        $this->tours[$key]['price'] = $this->toursData->where('id', $this->tours[$key]['id'])->first()->price;
    }

    public function addTour(): void
    {
        $this->tours[Str::uuid()->toString()] = [
            'id' => '',
            'price' => '',
            'quantity' => '',
            'total' => 0,
            'paid' => false,
        ];
    }

    public function removeTour(string $uuid): void
    {
        unset($this->tours[$uuid]);
    }

    public function mount(): void
    {
        $this->toursData = TourModel::all();
    }

    public function render()
    {
        return view('livewire.components.reservation.tour');
    }
}
