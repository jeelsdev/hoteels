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

    protected $listeners = ['before-save-reservation' => 'beforeSave'];

    public function beforeSave(): void
    {
        if($this->tours)
        {
            $this->validate([
                'tours.*.id' => 'required|exists:tours,id',
                'tours.*.price' => 'required|numeric',
                'tours.*.quantity' => 'required|numeric',
            ]);
        }

        $this->dispatch('validate-saved-reservation', [
            'component' => 'tour',
            'data' => $this->tours,
        ]);
    }

    public function calculate(string $dispatch): void
    {
        foreach($this->tours as $key => $tour)
        {
            $this->tours[$key]['total'] = (int) $tour['price'] * (int) $tour['quantity'];
        }

        $total = 0;

        switch($dispatch)
        {
            case 't-total':
                foreach($this->tours as $tour)
                {
                    $total += $tour['total'];
                }
                break;
            case 't-debt':
                foreach($this->tours as $tour)
                {
                    if(!$tour['paid'])
                    {
                        $total += $tour['total'];
                    }
                }
                break;
            case 'tours':
                $total = count($this->tours);
                break;
            default:
                $total = 0;
        }

        

        $this->dispatch('update-summary-' . $dispatch, $total);
    }

    public function setTour(string $key): void
    {
        $this->tours[$key]['price'] = $this->toursData->where('id', $this->tours[$key]['id'])->first()->price;

        if(!$this->tours[$key]['quantity'])
        {
            $this->tours[$key]['quantity'] = 1;
        }

        $this->calculate('t-total');
        $this->calculate('t-debt');
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

        $this->calculate('tours');
    }

    public function removeTour(string $uuid): void
    {
        unset($this->tours[$uuid]);

        $this->calculate('t-total');
        $this->calculate('t-debt');
        $this->calculate('tours');
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
