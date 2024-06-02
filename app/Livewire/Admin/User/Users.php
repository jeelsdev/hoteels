<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $search = '';

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('surname', 'like', '%'.$this->search.'%')
            ->orWhere('document', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('livewire.admin.user.users', compact('users'));
    }
}
