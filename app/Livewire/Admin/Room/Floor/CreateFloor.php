<?php

namespace App\Livewire\Admin\Room\Floor;

use App\Models\Floor;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateFloor extends Component
{
    public Floor $floor;
    public $create = true;

    #[Validate('required', 'max:50')]
    public $description;
    #[Validate(['required','between:1,30', 'numeric', 'unique:floors,denomination'])]
    public $denomination;

    #[On('editFloor')]
    public function edit($id)
    {
        $this->floor = Floor::findOrFail($id);
        $this->description = $this->floor->description;
        $this->denomination = $this->floor->denomination;
        $this->create = false;
    }

    public function update()
    {
        $this->validate();
        $this->floor->update([
            'description' => $this->description,
            'denomination' => $this->denomination,
        ]);
        $this->reset(['description', 'denomination']);
        $this->create = true;
        session()->flash('flash.message', 'Tipo de habitación actualizado correctamente.');
        $this->dispatch('refreshFloors')->to(Floor::class);
    }

    public function save()
    {
        $this->validate();
        Floor::create([
            'description' => $this->description,
            'denomination' => $this->denomination,
        ]);
        $this->reset(['description', 'denomination']);
        session()->flash('flash.message', 'Servicio: extra agregado correctamente.');
        $this->dispatch('refreshFloors')->to(Floor::class);
    }

    public function render()
    {
        return view('livewire.admin.room.floor.create-floor');
    }
}
