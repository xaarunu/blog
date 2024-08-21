<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserDataForm extends Component
{
    public $accion;
    public $user;
    public $datos;
    public $divisiones;
    public $areas;
    public $subareas;
    public $roles;
    public $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($divisiones, $areas, $subareas, $roles, $user = null, $datos = null, $accion = 'create') {
        $this->accion = $accion;
        $this->user = $user;
        $this->datos = $datos;
        $this->divisiones = $divisiones;
        $this->areas = $areas;
        $this->subareas = $subareas;
        $this->roles = $roles;

        switch ($accion) {
            case 'create':
                $this->route = route('users.store');
                break;
            case 'edit':
                $this->route = route('users.update', $user->id);
                break;
            case 'pendiente.show':
                $this->accion = 'show';
                $this->route = route('users.pendientes.update', $user->id);
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-data-form');
    }
}
