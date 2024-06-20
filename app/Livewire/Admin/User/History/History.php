<?php

namespace App\Livewire\Admin\User\History;

use App\Models\User;
use Livewire\Component;

class History extends Component
{
    public User $user;
    public $histories = [];
    public $information = [
        "total_reservations"=> 0,
        "total_tours"=> 0,
        "total_xtras"=> 0,
    ];
    protected function getInformationUser()
    {
        foreach ($this->histories as $history) {
            $this->information['total_reservations'] += $history->payment->total_reservation;
            $this->information['total_tours'] += $history->payment->total_tours;
            $this->information['total_xtras'] += $history->payment->total_xtras;
        }
        // dd($this->information);
    }
    public function getHistories(User $user)
    {
        $this->histories = $user->with("reservation")->get();
    }
    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->user = $user;
        $this->histories = $user->reservations()->orderBy("created_at","desc")->get();
        $this->getInformationUser();
    }
    public function render()
    {
        return view('livewire.admin.user.history.history');
    }
}
