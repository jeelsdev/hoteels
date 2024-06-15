<?php

namespace App\Livewire\Admin\Service\Tour;

use App\Models\Tour;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateTour extends Component
{
    public Tour $tour;
    public $create = true;

    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $price;

    #[On('editTour')]
    public function edit($id)
    {
        $this->tour = Tour::findOrFail($id);
        $this->name = $this->tour->name;
        $this->price = $this->tour->price;
        $this->create = false;
    }

    public function update()
    {
        $this->validate();
        $this->tour->update([
            'name' => $this->name,
            'price' => $this->price,
        ]);
        $this->reset(['name', 'price']);
        $this->create = true;
        session()->flash('flash.message', 'Tour actualizado correctamente');
        $this->dispatch('refreshTours')->to(Tours::class);
    }

    public function save()
    {
        $this->validate();
        Tour::create([
            'name' => $this->name,
            'price' => $this->price,
        ]);
        $this->reset(['name', 'price']);
        session()->flash('flash.message', 'Tour agregado correctamente');
        $this->dispatch('refreshTours')->to(Tours::class);
    }
    public function render()
    {
        return view('livewire.admin.service.tour.create-tour');
    }
}
