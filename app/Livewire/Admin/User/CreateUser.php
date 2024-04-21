<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateUser extends Component
{
    public $documentTypes = [];

    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $surname;
    #[Validate('required')]
    public $documentType;
    #[Validate('required')]
    public $document;
    #[Validate('required')]
    public $phone;
    #[Validate(['required', 'email'])]
    public $email;

    public function save()
    {
        $this->validate();
        $user = new User();
        $user->create([
            'name' => $this->name,
            'surname' => $this->surname,
            'document_type' => $this->documentType,
            'document' => $this->document,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => bcrypt('password'),
        ]);
        $this->reset(['name', 'surname', 'documentType', 'document', 'phone', 'email']);
        session()->flash('flash.message', 'Usuario creado correctamente.');
        return redirect()->route('users.index');
    }

    public function render()
    {
        $this->documentTypes = getEnumValues('DocumentType');
        return view('livewire.admin.user.create-user');
    }
}
