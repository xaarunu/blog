<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LentesForm extends Component
{
    public $accion;
    public $route;
    public $user;
    public $prestacion;
    public $modal;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($accion = 'create', $user = null, $prestacion = null, $modal = false)
    {
        $this->accion = $accion;
        $this->user = $user;
        $this->prestacion = $prestacion;
        $this->modal = $modal;

        switch ($accion) {
            case 'create':
                $this->route = route('lentes.store');
                break;
            case 'edit':
                $this->route = route('lentes.update', $prestacion->id);
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
        return view('components.lentes-form');
    }
}
