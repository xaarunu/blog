<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Area;
use App\Models\User;
use App\Models\Torneo;
use App\Models\Proceso;
use App\Models\Subarea;
use App\Models\Division;
use App\Models\Datosuser;
use App\Models\Subproceso;
use App\Models\Participante;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Office365\Teams\Participant;

class DatosPersonalesController extends Controller
{

    public function mostrarFormulario()
    {
        $divisiones = DB::table('divisiones')->get();
        $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
        $subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', 'DX17' . '%')->get();
        return view('datos.registrar',  ['areas' => $areas,'subareas' => $subareas, 'divisiones' => $divisiones,  ]);
    }

    public function guardarDatos(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required',

        ]);
        $user = auth()->user();
        $user->email = $request->email;
        $user->save();
        $request->merge(['rpe' => $user->rpe]);
        $datos = $request->all();
        Datosuser::create($datos);

        return redirect()->route('dashboard.index');
    }

    public function subcategorias(Request $request)
    {
        if (isset($request->texto)) {
            $area = $request->texto;
            $subcategorias = DB::table('subareas')->where('subarea_clave', 'lIKE', $area . '%')->get();
            return response()->json(
                [
                    'lista' => $subcategorias,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'datos' => $request
                ]
            );
        }
    }

    public function areas(Request $request)
    {
        if (isset($request->texto)) {
            $area = $request->texto;
            $areas = DB::table('areas')->where('area_clave', 'lIKE', $area . '%')->get();
            $subcategorias = DB::table('subareas')->where('subarea_clave', 'lIKE', $areas[0]->area_clave . '%')->get();
            return response()->json(
                [
                    'listaSub' => $subcategorias,
                    'lista' => $areas,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'datos' => $request
                ]
            );
        }
    }
}
