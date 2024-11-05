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

    protected $listeners = ['before-save-reservation', 'beforeSave'];

    public function beforeSave(): void
    {
        if($this->extras) {
            $this->validate([
                'extras.*.id' => 'required|exists:xtras,id',
                'extras.*.price' => 'required|numeric',
                'extras.*.quantity' => 'required|numeric',
            ]);
        }

        $this->dispatch('validate-saved-reservation', [
            'component' => 'extra',
            'data' => $this->extras,
        ]);
    }

    public function calculate(string $dispatch): void
    {
        foreach($this->extras as $key => $extra)
        {
            $this->extras[$key]['total'] = (int) $extra['price'] * (int) $extra['quantity'];
        }

        $total = 0;

        switch($dispatch)
        {
            case 'e-total':
                foreach($this->extras as $extra)
                {
                    $total += $extra['total'];
                }
                break;
            case 'e-debt':
                foreach($this->extras as $extra)
                {
                    if(!$extra['paid'])
                    {
                        $total += $extra['total'];
                    }
                }
                break;
            case 'extras':
                $total = count($this->extras);
                break;
            default:
                $total = 0;
        }

        $this->dispatch('update-summary-' . $dispatch, $total);
    }

    public function addExtra(): void
    {
        $this->extras[Str::uuid()->toString()] = [
            'id' => '',
            'price' => '',
            'quantity' => '',
            'total' => 0,
            'paid' => false,
        ];

        $this->calculate('extras');
    }

    public function setExtra(string $key): void
    {
        $this->extras[$key]['price'] = $this->extrasData->where('id', $this->extras[$key]['id'])->first()->price;

        if(!$this->extras[$key]['quantity'])
        {
            $this->extras[$key]['quantity'] = 1;
        }

        $this->calculate('e-total');
        $this->calculate('e-debt');
    }

    public function removeExtra(string $key): void
    {
        unset($this->extras[$key]);

        $this->calculate('extras');
        $this->calculate('e-total');
        $this->calculate('e-debt');
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
