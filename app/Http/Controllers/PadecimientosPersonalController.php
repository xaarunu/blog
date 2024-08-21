<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\usuario_enfermedad;
use App\Models\enfermedades_cronicas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Division;

class PadecimientosPersonalController extends Controller
{
    public function show(Request $request){
        // Obtén todas las áreas y subáreas
        $divisiones = Division::all();
        $areas = Area::where('division_id', Auth::user()->datos->division)->get();
        $subareas = Subarea::where('area_id', Auth::user()->datos->area)->get();
        $enfermedades = enfermedades_cronicas::all();
        
        // Obtener los usuarios enfermos
        $usuariosEnfermos = usuario_enfermedad::all();

        //Se transforma en array las enfermedad
        $etiquetasEnfermedades = $enfermedades->pluck('nombre')->toArray();
        //Obtener datos del modelo
        $query = usuario_enfermedad::query()
        ->with(['user', 'user.getArea', 'user.getSubarea', 'enfermedadCronica'])
        ->whereHas('user', function ($query) {
            $query->where('division', Auth::user()->datos->division)
                    ->where('area', Auth::user()->datos->area);
        });
        $usuariosEnfermos = $query->get();
        // Darle formato a los datos que se usaran en la primera carga de la grafica
        $usuariosEnfermosFormatted = $usuariosEnfermos->map(function ($usuarioEnfermo) {
            return [
                'rpe' => $usuarioEnfermo->user->rpe,
                'area' => $usuarioEnfermo->user->getArea->area_clave,
                'subarea' => $usuarioEnfermo->user->getSubarea->subarea_clave,
                'enfermedad' => $usuarioEnfermo->enfermedadCronica->nombre,
            ];
        });
        // Mandar todos los datos a la vista
        return view('Informes_enfermos_zona.showEnfermos', [
            'usuariosEnfermosFormatted' => $usuariosEnfermosFormatted,
            'divisiones' => $divisiones,
            'areas' => $areas,
            'subareas' => $subareas,
            'etiquetasEnfermedades'=> $etiquetasEnfermedades,
        ]);
    }

    public function filtrarUsuarios(Request $request)
    {
        
        // Obtener los datos recibidos
        $division = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        info($area);
        info($subarea);
        // Obtener los datos del modelo
        $query = usuario_enfermedad::query()
        ->with(['user', 'user.getArea', 'user.getSubarea', 'enfermedadCronica'])
        ->whereHas('user', function ($query) use($division) {
            $query->where('division', $division);
        })
        ->whereBetween('fecha_detectada', [$fechaInicial, $fechaFinal]);
        // Verificar si el usuario seleccionó "Todas las áreas" o "Todas las subáreas"
        if ($area !== 'all') {
            $query->whereHas('user', function ($query) use ($area, $subarea) {
                $query->where('area', $area);
                // Verificar si el usuario seleccionó "Todas las subáreas"
                if ($subarea !== 'all') {
                    $query->where('subarea', $subarea);
                }
            });
        }
        // Guardar en una variable los datos obtenidos
        $usuariosEnfermos = $query->get();
        info($usuariosEnfermos);
        // Enviar la respuesta formateada para el tratado en la grafica
        return response()->json([
            'users' => $usuariosEnfermos->map(function ($usuarioEnfermo) {
                return [
                    'rpe' => $usuarioEnfermo->user->rpe,
                    'area' => $usuarioEnfermo->user->getArea->area_clave,
                    'subarea' => $usuarioEnfermo->user->getSubarea->subarea_clave,
                    'enfermedad' => $usuarioEnfermo->enfermedadCronica->nombre,
                ];
            }),
            'success' => true,
        ]);

    }


}
