<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Navigation extends Component
{
    public $items = [];
    public $icon;
    public $title;
    public $open = false;

    public function openProfileMenu()
    {
        if($this->open) {
            $this->open = false;
        } else {
            $this->open = true;
        }
    }

    public function profile()
    {
        $this->items = [
            [
                'name' => 'Configuración',
                'route' => 'profile.show'
            ],
        ];
        $this->icon = 'users.svg';
        $this->title = 'Perfil';
    }

    public function movement()
    {
        $this->items = [
            [
                'name' => 'Panel',
                'route' => 'movement.index'
            ],
            [
                'name' => 'Ingresos diarios',
                'route' => 'movement.daily-income'
            ],
            [
                'name'=> 'Egresos',
                'route'=> 'movement.expenses'
            ]
        ];
        $this->icon = 'document-text.svg';
        $this->title = 'Movimientos';
    }

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
                'name' => 'Lista',
                'route' => 'users.index'
            ],
            [
                'name' => 'Informe de deudores',
                'route' => 'users.debtors'
            ]
        ];
        $this->icon = 'users.svg';
        $this->title = 'Huéspedes';
    }

    public function room()
    {
        $this->items = [
            [
                'name' => 'Habitaciones',
                'route' => 'room.rooms'
            ],
            [
                'name' => 'Lista',
                'route' => 'room.index'
            ],
            [
                'name'=> 'Pisos',
                'route'=> 'room.floor'
            ],
            [
                'name'=> 'Tipos de habitaciones',
                'route'=> 'room.types'
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
            in_array('movement',$urisegments) => $this->movement(),
            in_array('profile',$urisegments) => $this->profile(),
        };
    }

    public function render()
    {
        return view('livewire.layouts.navigation');
    }
}
