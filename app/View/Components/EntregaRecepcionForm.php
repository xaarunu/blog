<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class EntregaRecepcionForm extends Component
{
    public $accion;
    public $route;
    public $registro;
    public $ausente;
    public $receptor;
    public $roles;
    public $archivo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($accion = 'create', $registro = null, $userDefault = null)
    {
        $this->registro = $registro;
        $this->accion = $accion;
        $this->roles = []; // Valor inicial

        if($userDefault) {
            $this->ausente = $userDefault->datos;
        }

        // "Calculados" por el registro ya creado
        if($registro) {
            $this->ausente = $registro->usuarioAusente;
            $this->receptor = $registro->usuarioReceptor;
            $this->archivo =  $registro->archivo;

            $rolesPrestadosIds = $registro->rolesPrestados->pluck('id_rol');
            $this->roles = Role::whereIn('id', $rolesPrestadosIds)->get();

            if($accion == 'edit') {
                // Si fecha de inicio es despues de hoy, incluir roles disponibles de ausente
                if($registro->fecha_inicio > Date('Y-m-d')) {
                    $this->roles = $this->ausente->user->roles;
                }
            }

            // Diferenciar entre roles ya seleccionados y los disponibles
            $this->roles->map(function ($rol) use ($rolesPrestadosIds) {
                $rol['seleccionado'] = $rolesPrestadosIds->contains($rol->id);
                return $rol;
            });
        }        

        switch ($accion) {
            case 'create':
                $this->route = route('recepcion.store');
                break;
            case 'show':
                $this->route = "#";
                break;
            case 'edit':
                $this->route = route('recepcion.update', $registro->id);
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
        return view('components.entrega-recepcion-form');
    }
}
