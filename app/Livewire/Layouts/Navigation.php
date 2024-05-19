<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Navigation extends Component
{
    public $items = [];
    public $icon;
    public $title;

    public function service()
    {
        $this->items = [
            [
                'name' => 'Extras',
                'route' => 'xtras.index'
            ],
            [
                'name' => 'Tours',
                'route' => 'tours.index'
            ]
        ];
        $this->icon = 'rectangle-group.svg';
        $this->title = 'Servicios';
    }

    public function user()
    {
        $this->items = [
            [
                'name' => 'Usuarios',
                'route' => 'users.index'
            ]
        ];
        $this->icon = 'users.svg';
        $this->title = 'Usuarios';
    }

    public function room()
    {
        $this->items = [
            [
                'name' => 'Habitaciones',
                'route' => 'room.index'
            ]
        ];
        $this->icon = 'room.svg';
        $this->title = 'Habitaciones';
    }

    public function reservation()
    {
        $this->items = [
            [
                'name' => 'Calendario',
                'route' => 'reservation.index'
            ],
            [
                'name' => 'Listado de reservas',
                'route' => 'reservation.list'
            ]
        ];
        $this->icon = 'calendar.svg';
        $this->title = 'Reservas';
    }

    public function dashboard()
    {
        $this->items = [
            [
                'name' => 'Informe de rendimiento',
                'route' => 'dashboard.report'
            ],
            [
                'name' => 'Ingresos diarios',
                'route' => 'dashboard.daily-income'
            ],
            [
                'name' => 'Informe de deudores',
                'route' => 'dashboard.debtors'
            ]
        ];
        $this->icon = 'chart-pie.svg';
        $this->title = 'Dashboard';
    }

    public function mount()
    {
        // capture the current route
        $currentRoute = request()->route()->uri();
        $urisegments = explode('/', $currentRoute);

        // match the current route
        match (true) {
            in_array('dashboard',$urisegments) => $this->dashboard(),
            in_array('reservation',$urisegments) => $this->reservation(),
            in_array('users',$urisegments) => $this->user(),
            in_array('service',$urisegments) => $this->service(),
            in_array('room',$urisegments) => $this->room(),
        };
    }

    public function render()
    {
        return view('livewire.layouts.navigation');
    }
}
