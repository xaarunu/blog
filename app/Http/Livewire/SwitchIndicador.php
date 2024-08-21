<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Indicador;
use App\Models\IndicadorSwitch;
use App\Models\porcentaje_penalizacion;

class SwitchIndicador extends Component
{
    public $indicadores;
    public $nombreIndicador;
    public $penalizacionAmarillo;
    public $penalizacionRojo;
    public $valorAmarillo;
    public $valorRojo;
    public $errorMessage = '';
    public $acceptMessage = '';

    public $rules = [
        'valorAmarillo' => 'required',
    ];
    public function render()
    {
        $this->indicadores = IndicadorSwitch::all();
        $this->nombreIndicador = Indicador::$INDICATORS_DESCRIPTIONS;
        $this->penalizacionAmarillo = porcentaje_penalizacion::where('color', 'amarillo')->get();
        $this->penalizacionRojo = porcentaje_penalizacion::where('color', 'rojo')->get();
        

        return view('livewire.switch-indicador');
    }

    public function mount()
    {
        $this->indicadores = IndicadorSwitch::all();
        $this->nombreIndicador = Indicador::$INDICATORS_DESCRIPTIONS;
        $this->penalizacionAmarillo = porcentaje_penalizacion::where('color', 'amarillo')->get();
        $this->penalizacionRojo = porcentaje_penalizacion::where('color', 'rojo')->get();
        $this->valorAmarillo = $this->penalizacionAmarillo[0]->penalizacion;
        $this->valorRojo = $this->penalizacionRojo[0]->penalizacion;
        $this->errorMessage = '';
        $this->acceptMessage = '';
    }

    public function update($id)
    {
        $indicador = IndicadorSwitch::where('indicador',$id)->first();
        if($indicador->encendido == 1)
        {
            $indicador->encendido = 0;
        }
        else{
            $indicador->encendido = 1;  
        }
        $indicador->save();
    }

    public function cambiarPenalizacion()
    {
        $valorAmarillo = $this->valorAmarillo;
        $valorRojo = $this->valorRojo;
        $cont = 0;

        try {
            $penalizacionYellow = porcentaje_penalizacion::where('color', 'amarillo')->firstOrFail();
            $penalizacionYellow->penalizacion = $valorAmarillo;
            $penalizacionYellow->save();
            $cont++;
        } catch (\Exception $e) {
            $this->errorMessage = 'Se produjo un error al cambiar la penalización: ' . $e->getMessage();
        }

        try {
            $penalizacionRed = porcentaje_penalizacion::where('color', 'rojo')->firstOrFail();
            $penalizacionRed->penalizacion = $valorRojo;
            $penalizacionRed->save();
            $cont++;
        } catch (\Exception $e) {
            $this->errorMessage = 'Se produjo un error al cambiar la penalización: ' . $e->getMessage();
        }

        if($cont == 2)
        {
            $this->acceptMessage = 'Penalizacion Cambiada Correctamente';
        }
    }

    public function mensajes()
    {
        $this->errorMessage = '';
        $this->acceptMessage = '';
    }

}
