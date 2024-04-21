<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditUser extends Component
{
    public User $user;
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
        $this->user->update([
            'name' => $this->name,
            'surname' => $this->surname,
            'document_type' => $this->documentType,
            'document' => $this->document,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => bcrypt('password'),
        ]);

        session()->flash('flash.message', 'Usuario actualizado correctamente.');
        return redirect()->route('users.index');
    }

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->name = $this->user->name;
        $this->surname = $this->user->surname;
        $this->documentType = $this->user->document_type;
        $this->document = $this->user->document;
        $this->phone = $this->user->phone;
        $this->email = $this->user->email;
        $this->documentTypes = getEnumValues('DocumentType');
    }
    public function render()
    {
        return view('livewire.admin.user.edit-user');
    }
}
