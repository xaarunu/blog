<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\status;
use App\Models\RijSick;
use App\Models\Subarea;
use App\Models\Division;
use App\Models\Datosuser;
use App\Models\Incapacidad;
use Illuminate\Http\Request;
use App\Models\Incapacitados;
use App\Mail\BIENESTARcorreos;
use App\Models\PersonalSintomas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PersonalSintomasController extends Controller
{
    public function index(){
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        $Personal_sintomas = PersonalSintomas::where('attended', '==', 0)->with(['user.getArea','user.getSubarea','nota'=>function($query){
            $query-> latest('fecha')->limit(1);
        }])->get();
        info($Personal_sintomas);

        return view('personal_con_sintomas.index',[
            'areas' => $areas,
            'subareas' => $subareas,
            'Personal_sintomas' => $Personal_sintomas
        ]);
    }

    public function filtroPersonalSintomas(Request $request){
        $area = $request->area;
        $subarea = $request->subarea;
        $fecha_inicio = date($request->input('fecha_inicio'));
        $fecha_fin = date($request->input('fecha_fin'));
        $query = PersonalSintomas::with(['user.getArea','user.getSubarea','nota'=>function ($query){
            $query->latest('fecha')->limit(1);
        }]);
        if ($area !== 'all'){
                $query->where('area', $area);
                // Verificar si el usuario seleccionó "Todas las subáreas"
                if ($subarea !== 'all') {
                    $query->where('subarea', $subarea);
                }
        }
        $query->whereBetween('fecha_deteccion', [$fecha_inicio, $fecha_fin]);// Filtrar por fechas
        $personalFiltrado = $query->get();
        return response()->json([
            'users' => $personalFiltrado,
        ]);

    }
    public function filtroPersonalSintomasAtendido(Request $request){
        $area = $request->area;
        $subarea = $request->subarea;
        $fecha_inicio = date($request->input('fecha_inicio'));
        $fecha_fin = date($request->input('fecha_fin'));
        $query = PersonalSintomas::with(['user.getArea','user.getSubarea','nota'=>function ($query){
            $query->latest('fecha')->limit(1);
        }]);
        if ($area !== 'all'){
                $query->where('area', $area);
                // Verificar si el usuario seleccionó "Todas las subáreas"
                if ($subarea !== 'all') {
                    $query->where('subarea', $subarea);
                }
        }
        $query->whereBetween('fecha_deteccion', [$fecha_inicio, $fecha_fin]);// Filtrar por fechas
        $query->where('attended',1);
        $personalFiltrado = $query->get();
        return response()->json([
            'users' => $personalFiltrado,
        ]);

    }

    public function showPersonalAtendido(){
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        $Personal_sintomas_atendido = PersonalSintomas::with(['user.getArea','user.getSubarea','nota'=>function($query){
            $query->latest('fecha')->limit(1);
        }])->where('attended',1)->get();

        return view('personal_con_sintomas.show-personal-atendido',[
            'areas' => $areas,
            'subareas' => $subareas,
            'Personal_sintomas_atendido' => $Personal_sintomas_atendido
        ]);
    }

    public function marcarAtendido($id){
        $personal_sintomas = PersonalSintomas::find($id);
        $personal_sintomas->attended = true;
        $personal_sintomas->save();

        $fechaDeteccion = $personal_sintomas['fecha_deteccion'];
        $deteccionFormato = date('d-m-Y', strtotime($fechaDeteccion));

        $fechaAtendido = $personal_sintomas['updated_at'];
        $atendidoFormato = date('d-m-Y', strtotime($fechaAtendido));

        $datosuser = Datosuser::where('rpe', $personal_sintomas->rpe)->first();
        $nombre = $datosuser ? implode(' ', $datosuser->only(['nombre', 'paterno', 'materno'])) : '';

        $email = User::where('rpe', $personal_sintomas->rpe)->first()->email;
        //$emailAdmin = $email->email;//correo del admin

        $vista = 'reporte';
        Mail::to($email)->send(new BIENESTARcorreos(
            $atendidoFormato,
            $nombre,
            null,
            null,
            $deteccionFormato,
            null,
            $vista,
        ));

        return redirect()->route('personal_sintomas_atendido.show')->with('success','El registro se marco como atendido correctamente.');
    }

    public function marcarIncapacidadAtendida($id){
        $personal_incapacitado= Incapacitados::find($id);
        $personal_incapacitado->attended = true;
        $personal_incapacitado->save();
        return redirect()->route('personal_sintomas_incapacitado.show')->with('success','El registro se marco como atendido correctamente.');
    }

    public function showPersonalIncapacitado() {
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        $showPersonalIncapacitado = Incapacidad::where([
            ['fecha_inicio', '>=', date('Y-m-d')],
            ['fecha_fin', '<=', date('Y-m-d')]
            ])->get();

        return view('personal_con_sintomas.show-personal-incapacitado',[
            'areas' => $areas,
            'subareas' => $subareas,
            'showPersonalIncapacitado' => $showPersonalIncapacitado
        ]);
    }
    
    public function showIncapacidadPersonal($rpe)
    {
        $divisiones = Division::all();
        $areas = Area::where('division_id', $divisiones[0]->division_clave)->get();
        $subareas = Subarea::where('area_id', $areas[0]->area_clave)->get();
        $datosuser = Datosuser::with('incapacidades')
            ->where('division', $divisiones[0]->division_clave)
            ->where('area', $areas[0]->area_clave)
            ->where('rpe',$rpe)->get();

        $incapacidades = $datosuser->flatMap(function ($datosuser) {
            return $datosuser->incapacidades;
        });
        $datosuser = Datosuser::where('rpe',$rpe)->get();
        $RijIncapacidad = true;
        $nombreCompleto = implode(' ', [$datosuser[0]['nombre'], $datosuser[0]['paterno'], $datosuser[0]['materno']]);
        return view('incapacidades.index', ['incapacidades' => $incapacidades, 'divisiones' => $divisiones, 'areas' => $areas, 'subareas' => $subareas, 'RijIncapacidad'=>$RijIncapacidad, 'nombreCompleto'=>$nombreCompleto, 'rpe'=>$rpe]);
    }

    public function filtroPersonalIncapacitado(Request $request){
        $area = $request->area;
        $subarea = $request->subarea;
        $fecha_inicio = date($request->input('fecha_inicio'));
        $fecha_fin = date($request->input('fecha_fin'));
        $query = Incapacidad::with(['user', 'user.user.salud' => function ($query) {
            $query->latest('fecha')->limit(1);
        }])
            ->when($area !== 'all', function ($query) use ($area) {
                return $query->whereHas('user', function ($query) use ($area) {
                    $query->where('area', $area);
                });
            });
        
        // Verificar si el usuario seleccionó "Todas las subáreas"
        if ($subarea !== 'all') {
            $query->whereHas('user', function ($query) use ($subarea) {
                return $query->where('subarea', $subarea);
            });
        }

        $query->where([
            ['fecha_inicio', '>=', $fecha_inicio],
            ['fecha_fin', '<=', $fecha_fin]
        ]);
        $personalFiltrado = $query->get();

        return response()->json([
            'users' => $personalFiltrado,
        ]);
    }
}
