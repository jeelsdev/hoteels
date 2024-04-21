<?php

namespace App\Livewire\Admin\Service\Xtra;

use App\Models\Xtra;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateXtra extends Component
{
    public Xtra $xtra;
    public $create = true;

    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $price;

    #[On('editXtra')]
    public function edit($id)
    {
        $this->xtra = Xtra::findOrFail($id);
        $this->name = $this->xtra->name;
        $this->price = $this->xtra->price;
        $this->create = false;
    }

    public function update()
    {
        $this->validate();
        $this->xtra->update([
            'name' => $this->name,
            'price' => $this->price,
        ]);
        $this->reset(['name', 'price']);
        $this->create = true;
        session()->flash('flash.message', 'Servicio: extra actualizado correctamente.');
        $this->dispatch('refreshXtras')->to(Xtras::class);
    }

    public function save()
    {
        $this->validate();
        Xtra::create([
            'name' => $this->name,
            'price' => $this->price,
        ]);
        $this->reset(['name', 'price']);
        session()->flash('flash.message', 'Servicio: extra agregado correctamente.');
        $this->dispatch('refreshXtras')->to(Xtras::class);
    }

    public function render()
    {
        return view('livewire.admin.service.xtra.create-xtra');
    }
}
