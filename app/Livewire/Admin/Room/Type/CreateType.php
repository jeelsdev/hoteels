<?php

namespace App\Livewire\Admin\Room\Type;

use App\Models\RoomType;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateType extends Component
{
    public RoomType $roomType;
    public $create = true;

    #[Validate('required', 'max:50')]
    public $description;
    #[Validate(['required', 'max:20'])]
    public $denomination;
    #[Validate(['required', 'numeric'])]
    public $price;

    #[On('editType')]
    public function edit($id)
    {
        $this->roomType = RoomType::findOrFail($id);
        $this->description = $this->roomType->description;
        $this->denomination = $this->roomType->denomination;
        $this->price = $this->roomType->price;
        $this->create = false;
    }

    public function update()
    {
        $this->validate();
        $this->roomType->update([
            'description' => $this->description,
            'denomination' => $this->denomination,
            'price' => $this->price,
        ]);
        $this->reset(['description', 'denomination']);
        $this->create = true;
        session()->flash('flash.message', 'Tipo de habitación actualizado correctamente.');
        $this->dispatch('refreshTypes')->to(Types::class);
    }

    public function save()
    {
        $this->validate();
        RoomType::create([
            'description' => $this->description,
            'denomination' => $this->denomination,
            'price' => $this->price,
        ]);
        $this->reset(['description', 'denomination', 'price']);
        session()->flash('flash.message', 'Servicio: extra agregado correctamente.');
        $this->dispatch('refreshTypes')->to(Types::class);
    }

    public function render()
    {
        return view('livewire.admin.room.type.create-type');
    }
}
