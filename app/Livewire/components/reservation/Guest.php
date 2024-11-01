<?php

namespace App\Livewire\Components\Reservation;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class Guest extends Component
{
    public array $users;
    
    public String $tab;

    protected $rules = [
        'users.*.name' => 'required|string',
        'users.*.lastName' => 'required|string',
        'users.*.email' => 'required|email',
        'users.*.phone' => 'numeric',
        'users.*.document' => 'required|numeric',
        'users.*.documentType' => 'required|string',
    ];

    public function save(): void
    {
        $this->validate();

        foreach ($this->users as $user)
        {
            User::create([
                'name' => $user['name'],
                'surname' => $user['lastName'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'document' => $user['document'],
                'document_type' => $user['documentType'],
            ]);
        }

        $this->emit('saved');
    }

    public function setUser(): void
    {
        $this->users[Str::uuid()->toString()] = [
            'name' => '',
            'lastName' => '',
            'email' => '',
            'phone' => '',
            'document' => '',
            'documentType' => '',
        ];

        $this->setTab(array_key_last($this->users));
    }

    public function removeUser(String $key): void
    {
        unset($this->users[$key]);
        $this->setTab(array_key_last($this->users));
    }

    public function findUser(String $key): void
    {
        $this->validate([
            "users.{$key}.document" => 'required|numeric',
        ]);

        $user = User::where('document', $this->users[$key]['document'])->first();
        
        if ($user)
        {
            $this->users[$key] = [
                'name' => $user->name,
                'lastName' => $user->surname,
                'email' => $user->email,
                'phone' => $user->phone,
                'document' => $user->document,
                'documentType' => $user->document_type,
            ];
            return;
        }

        $this->addError("users.{$key}.document", 'Huésped no encontrado');
    }

    public function setTab(String $tab): void
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->setUser();
        $this->setTab(array_key_first($this->users));
    }

    public function render()
    {
        return view('livewire.components.reservation.guest');
    }
}
