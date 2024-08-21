<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MiSalud;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Session;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session as FacadesSession;

// use Auth;

class ReportesSaludController extends Controller
{
    public function show()
    {   $saluds = [];

         // Initialize notasmes array
        $notasmes = [];
        for($entero = 1; $entero < 13; $entero++){
            $notasmes[] = MiSalud::whereYear('fecha', today()->year)->whereMonth('fecha',$entero)->count();
        }
        // Find maximum nota
        $maximo = max($notasmes);
         // Prepare data for chart
        $saluds[] = ['label' => 'Notas Medicas','data' => $notasmes, 'backgroundColor' => 'rgba(35, 177, 13, 0.8)'];
        $hasNonZeroValues = false;
        // Check if there are non-zero values
        foreach ($saluds as $salud) {
            if (is_array($salud['data']) && array_sum($salud['data']) > 0) {
                $hasNonZeroValues = true;
                break;
            }
        }

        // return view('reportesSalud.show')->with('saluds',json_encode($saluds,JSON_NUMERIC_CHECK))->with('maxNota',$maximo);
        // Return view with data
        return view('reportesSalud.show', [
            'saluds' => json_encode($saluds, JSON_NUMERIC_CHECK),
            'maxNota' => $maximo,
            'hasNonZeroValues' => $hasNonZeroValues,
        ]);


    }
}
