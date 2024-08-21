<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Doping;
use App\Models\Subarea;
use App\Models\ProSalud;
use App\Models\Datosuser;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProSaludController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:prosalud.index')->only('index', 'show', 'historicoUsuario', 'filtrar');
        $this->middleware('can:prosalud.create')->only('create', 'store');
        $this->middleware('can:prosalud.edit')->only('edit', 'actualiza');
        $this->middleware('can:prosalud.delete')->only('destroy');
        $this->middleware('can:prosalud.stats')->only('estadisticaDato', 'estadisticaZona','general', 'examenes', 'graficaHistorial');
        $this->middleware('can:antidoping.index')->only('antidopingIndex');
    }

    public function index() {
        $usuarios = ProSalud::with('usuario.getArea')->get();
        $AñoActual = Carbon::now()->year;

            $años = [];

            for ($i = $AñoActual - 3; $i <= $AñoActual + 3; $i++) {
                $años[] = $i;
            }
        foreach($usuarios as $usuario) {
            $areaNombre = Area::where('area_clave', $usuario->zona)->pluck('area_nombre')->first();
            $usuario->setAttribute('area_nombre', $areaNombre);
        }
        $areas = Area::get();
        return view('prosalud.index', ['usuarios' => $usuarios, 'areas' => $areas, 'años' => $años]);
    }
    public function filtrar(Request $request){
        $area = $request->input('areaFilter');
        $fecha= $request->input('filtro_fecha');

        if($area != "all"){//si se selecciona area
                if($fecha !="all"){//si se selecciona area y fecha
                    $usuarios = ProSalud::where('zona', $area)
                    ->whereYear('fecha_toma', $fecha)
                    ->get();
                }else{//si no se seleccionan fechas
                    $usuarios = ProSalud::where('zona', $area)->get();
                }
        }else{//si no se selecciona area
            if($fecha != "all"){//si se selecciona fecha
                $usuarios = ProSalud::whereYear('fecha_toma', $fecha)
                ->get();
            }else{
                $usuarios = ProSalud::get();
            }
        }
        foreach($usuarios as $usuario) {
            $areaNombre = Area::where('area_clave', $usuario->zona)->pluck('area_nombre')->first();
            $usuario->setAttribute('area_nombre', $areaNombre);
        }
        return response()->json($usuarios);
    }

    public function create() {
        $areas = Area::where('division_id', 'DX')->get();

        return view('prosalud.create', ['areas' => $areas]);
    }

    public function show($id) {

        $expediente = ProSalud::where('id', $id)->first();
        $glucosa_rango =  explode('-', $expediente->glucosa_referencia);
        $expediente->glucosa_resultado < $glucosa_rango[0] ? $expediente->glucosa_bajo = true : '';
        $expediente->glucosa_resultado > $glucosa_rango[1] ? $expediente->glucosa_alto = true : '';
        $trigliceridos_rango =  explode('-', $expediente->trigliceridos_referencia);
        $expediente->trigliceridos_resultado < $trigliceridos_rango[0] ? $expediente->trigliceridos_bajo = true : '';
        $expediente->trigliceridos_resultado > $trigliceridos_rango[1] ? $expediente->trigliceridos_alto = true : '';
        $expediente->colesterol_resultado >= 200 ? $expediente->colesterol_alto = true : '';
        $plaquetas_rango =  explode('-', $expediente->plaquetas_referencia);
        $expediente->plaquetas_resultado < $plaquetas_rango[0] ? $expediente->plaquetas_bajo = true : '';
        $expediente->plaquetas_resultado > $plaquetas_rango[1] ? $expediente->plaquetas_alto = true : '';
        $leucocitos_rango =  explode('-', $expediente->leucocitos_referencia);
        $expediente->leucocitos_resultado < $leucocitos_rango[0] ? $expediente->leucocitos_bajo = true : '';
        $expediente->leucocitos_resultado > $leucocitos_rango[1] ? $expediente->leucocitos_alto = true : '';
        $hemoglobina_rango =  explode('-', $expediente->hemoglobina_referencia);
        $expediente->hemoglobina_resultado < $hemoglobina_rango[0] ? $expediente->hemoglobina_bajo = true : '';
        $expediente->hemoglobina_resultado > $hemoglobina_rango[1] ? $expediente->hemoglobina_alto = true : '';
        return view('prosalud.show', ['expediente' => $expediente]);
    }

    public function historicoUsuario($rpe)
    {
        // Comprobar que exista un usuario con el rpe solicitado
        $usuario = Datosuser::where('rpe', $rpe)->firstOrFail();
        $registros = ProSalud::where('rpe', $rpe)->get();

        return view('prosalud.historicoUsuario', compact('usuario', 'registros'));
    }

    public function findUser(Request $request)
    {
        $search = strtoupper($request->input('rpe'));
        $results = DB::table('datosusers')->where('rpe', 'like', '%' . $search . '%')->limit(5)->get();
        return response()->json(['success' => true, 'coincidencias' => $results]);
    }
    public function buscarNombre(Request $request)
    {
        $search = strtoupper($request->input('query'));
        $split = explode(" ", $search);
        $query =  Datosuser::select(DB::raw('datosusers.*,
            MATCH (nombre, paterno, materno) AGAINST (\'' . $search . '\' IN NATURAL LANGUAGE MODE) AS score
        '))
            ->with('user')
            ->with('getSubarea')
            ->orWhere('rpe', 'like', '%' . $search . '%')
            ->orWhereFullText(['nombre', 'paterno', 'materno'], $search);
        foreach ($split as $value) {
            $query->orWhere(function ($query) use ($value) {
                $query->orWhere('nombre', 'like', '%' . $value . '%');
                $query->orWhere('paterno', 'like', '%' . $value . '%');
                return $query->orWhere('materno', 'like', '%' . $value . '%');
            });
        }
        $query->orderBy('score', 'desc');
        $results = $query->take(5)->get();
        return response()->json(['success' => true, 'coincidencias' => $results]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'rpe' => 'required|size:5',
            'nombre' => 'required',
            'fecha_toma' => 'required',
            'edad' => 'required',
            'zona' => 'required',
        ]);
        $prosalud = new ProSalud();

        $prosalud->rpe = $request->input('rpe');
        $prosalud->nombre = $request->input('nombre');
        $prosalud->fecha_Toma = $request->input('fecha_toma');
        $prosalud->edad = $request->input('edad');
        $prosalud->glucosa_resultado = $request->input('glucosa_resultado');
        $prosalud->glucosa_unidades = "mg/dL";
        $prosalud->glucosa_referencia = "60-110";
        $prosalud->trigliceridos_resultado = $request->input('trigliceridos_resultado');
        $prosalud->trigliceridos_unidades = "mg/dL";
        $prosalud->trigliceridos_referencia = "40-160";
        $prosalud->colesterol_resultado = $request->input('colesterol_resultado');
        $prosalud->colesterol_unidades = "mg/dL";
        $prosalud->colesterol_referencia = "menos de 200";
        $prosalud->hemoglobina_resultado = $request->input('hemoglobina_resultado');
        $prosalud->hemoglobina_unidades = "g/dL";
        $prosalud->hemoglobina_referencia ="14*18";
        $prosalud->leucocitos_resultado = $request->input('leucocitos_resultado');
        $prosalud->leucocitos_unidades = "x 10 3/ml";
        $prosalud->leucocitos_referencia = "4.8-10.6";
        $prosalud->plaquetas_resultado = $request->input('plaquetas_resultado');
        $prosalud->plaquetas_unidades = "x 10 3/ml";
        $prosalud->plaquetas_referencia = "130-400";
        $prosalud->zona = $request->input('zona');

        $prosalud->save();

        return redirect()->route('prosalud.index')->with('success', 'Informacion actualizada exitosamente');

    }
    public function edit($id)
    {
        $expediente = ProSalud::where('id', $id)->first();
        $zonas = Area::where('division_id', 'DX')->get();

        return view('prosalud.edit', ['expediente' => $expediente, 'zonas' => $zonas]);
    }
    public function actualiza(Request $request)
    {
        $id = $request->input('id');
        $prosalud = ProSalud::findOrFail($id);
        $prosalud->rpe = $request->input('rpe');
        $prosalud->nombre = strtoupper($request->input('nombre'));
        $prosalud->fecha_Toma = $request->input('fecha_toma');
        $prosalud->edad = $request->input('edad');
        $prosalud->glucosa_resultado = $request->input('glucosa_resultado');
        $prosalud->glucosa_unidades = "mg/dL";
        $prosalud->glucosa_referencia = "60-110";
        $prosalud->trigliceridos_resultado = $request->input('trigliceridos_resultado');
        $prosalud->trigliceridos_unidades = "mg/dL";
        $prosalud->trigliceridos_referencia = "40-160";
        $prosalud->colesterol_resultado = $request->input('colesterol_resultado');
        $prosalud->colesterol_unidades = "mg/dL";
        $prosalud->colesterol_referencia = "menos de 200";
        $prosalud->hemoglobina_resultado = $request->input('hemoglobina_resultado');
        $prosalud->hemoglobina_unidades = "g/dL";
        $prosalud->hemoglobina_referencia ="14*18";
        $prosalud->leucocitos_resultado = $request->input('leucocitos_resultado');
        $prosalud->leucocitos_unidades = "x 10 3/ml";
        $prosalud->leucocitos_referencia = "4.8-10.6";
        $prosalud->plaquetas_resultado = $request->input('plaquetas_resultado');
        $prosalud->plaquetas_unidades = "x 10 3/ml";
        $prosalud->plaquetas_referencia = "130-400";
        $prosalud->zona = $request->input('zona');

        $prosalud->save();
        return redirect()->route('prosalud.index')->with('success', 'Informacion actualizada exitosamente');
    }
    public function destroy($id)
    {
        $prosalud = ProSalud::find($id);
        if ($prosalud) {
            $prosalud->delete();
        }
        return redirect()->back()->with('success', 'Expediente Eliminado Correctamente');
    }

    public function antidopingIndex() {
        $antidoping = Doping::all();

        return view('prosalud.indexAntidoping', ['antidoping' => $antidoping]);
    }
    public function general(Request $request){
        $zonas = ProSalud::select('zona')->groupBy('zona')->get()->mapWithKeys(function($zona){
            $nombreZona = Area::where('area_clave', $zona->zona)->firstOrFail();
            return [$zona->zona => $nombreZona->area_nombre];
        });
        if($request->user()->hasAnyRole(['admin', 'Doctora'])){
            $fechas = ProSalud::selectRaw('YEAR(fecha_toma) as fecha')->groupByRaw('YEAR(fecha_toma)')->orderByRaw('YEAR(fecha_toma) DESC')->get()->pluck('fecha');
            if(isset($request->zona) && isset($request->fecha)){
                $usuarios = ProSalud::where('zona', $request->zona)
                                ->whereRaw('YEAR(fecha_toma) = ' . $request->fecha)
                                ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                                ->get();
            }else if(isset($request->fecha)){
                $usuarios = ProSalud::whereRaw('YEAR(fecha_toma) = ' . $request->fecha)
                                ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                                ->get();
            }
            else{
                $usuarios = ProSalud::whereRaw('YEAR(fecha_toma) = ' . $fechas[0])
                            ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                            ->get();
            }
            $totalUsuariosZonas = $request->zona == null ?
                                Datosuser::whereIn('area', $zonas->keys()->values())->get()
                                : Datosuser::where('area', $request->zona)->get();
        }else{
            $zona = Datosuser::where('rpe', $request->user()->rpe)->firstorFail();
            $fechas = ProSalud::selectRaw('YEAR(fecha_toma) as fecha')
                        ->groupByRaw('YEAR(fecha_toma)')
                        ->orderByRaw('YEAR(fecha_toma) DESC')
                        ->where('zona', $zona->area)
                        ->get()->pluck('fecha');
            if(isset($request->fecha)){
                $usuarios = ProSalud::whereRaw('YEAR(fecha_toma) = ' . $request->fecha)
                                ->where('zona', $zona->area)
                                ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                                ->get();
            }
            else{
                $usuarios = ProSalud::whereRaw('YEAR(fecha_toma) = ' . $fechas[0])
                                ->where('zona', $zona->area)
                                ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                                ->get();
            }

            $totalUsuariosZonas = Datosuser::where('area', $zona->area)->get();
        }

        // 'Glucosa',
        // 'Trigliceridos',
        // 'Colesterol',
        // 'Hemoglobina',
        // 'Leucitos',
        // 'Plaquetas'
        switch ($request->tipo) {
            case 'bajo':
                # code...
                $resultado = $this->GetSintomasBajos($usuarios);
                $tipo = 'bajo';
                break;
            case 'normal':
                $resultado = $this->GetSintomasNormales($usuarios);
                $tipo = 'normal';
                break;
            case 'alto':
                $resultado = $this->GetSintomasAltos($usuarios);
                $tipo = 'alto';
                break;
            default:
                # code...
                $resultado = $this->GetSintomasNormales($usuarios);
                $tipo = 'normal';
                break;
        }

        $totalUsuarios = collect();
        $resultado->map(function($padecimiento) use(&$totalUsuarios){
            $padecimiento->mapWithKeys(function($usuario) use(&$totalUsuarios){
                try {
                    $totalUsuarios[$usuario->rpe];
                } catch (\Throwable $th) {
                    $totalUsuarios[$usuario->rpe] = $usuario;
                }
                return $usuario;
            });
        });

        $rpes = $totalUsuarios->keys()->values();
        $totalUsuarios = Datosuser::whereIn('rpe', $rpes)->get();

        $resultadoDatos = $this->obtenerNumeroDatos($resultado);
        $resultadoZonas = $this->asignarZonasADatos($resultado);

        try{
            $zonaObjetivo = $request->zona ?? $zonas[$zona->area];
        }catch(\Throwable $error){
            $zonaObjetivo = null;
        }

        return view('estadisticas.prosalud.general', [
            'totalTrabajadores' => $totalUsuarios,
            'totalTrabajadoresZonas' => $totalUsuariosZonas,
            'resultado' => $resultadoDatos,
            'resultadoZonas' => $resultadoZonas,
            'zonas' => $zonas,
            'fechas' => $fechas,
            'fechaObjetivo' => $request->fecha ?? $fechas[0],
            'zonaObjetivo' => $zonaObjetivo,
            'hasNonZeroValues' => $usuarios->count() > 0,
            'permisos' => $request->user()->hasAnyRole(['admin', 'Doctora']),
            'tipo' => $tipo
        ]);
    }

    public function asignarZonasADatos(Collection $datos){
        $resultado = $datos->map(function($dato){
            return $dato->groupBy('zona');
        });

        return $resultado;
    }

    public function estadisticaDato(Request $request){
        $request->merge(['dato' => strtolower($request->dato)]);
        $resultado = $this->getIndiceByDato($request->dato);

        return view('estadisticas.prosalud.dato', [
            'resultado' => $resultado,
            'hasNonZeroValues' => count($resultado) > 0,
            'dato' => ucfirst($request->dato)
        ]);
    }

    public function estadisticaZona(Request $request){
        if(!isset($request->zona)){
            $request->merge(['zona' => 'Oficionas Divisionales']);
        }
        $zonas = ProSalud::select('zona')->groupBy('zona')->get()->map(function($zona){
            return $zona->zona;
        });
        $usuarios = ProSalud::where('zona', $request->zona)->get();

        $bajos = $this->obtenerNumeroDatos($this->GetSintomasBajos($usuarios));
        $normal = $this->obtenerNumeroDatos($this->GetSintomasNormales($usuarios));
        $altos = $this->obtenerNumeroDatos($this->GetSintomasAltos($usuarios));

        return view('estadisticas.prosalud.zona', [
            'bajos' => $bajos,
            'normal' => $normal,
            'altos' => $altos,
            'zonaActual' => $request->zona,
            'zonas' => $zonas,
            'hasNonZeroValues' => $usuarios->count() > 0,
        ]);
    }

    public function getIndiceByDato($dato): Array{
        $usuarios = ProSalud::all();
        $dato_referencia = $dato.'_referencia';
        $dato_resultado = $dato.'_resultado';

        switch ($dato) {
            case 'hemoglobina':
                $bajo = $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode('*', $usuario->$dato_referencia);
                    if(count($rango) != 2){
                        return false;
                    }
                    return $usuario->$dato_resultado < $rango[0];
                });
                $normal = $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode('*', $usuario->$dato_referencia);
                    if(count($rango) != 2){
                        return false;
                    }
                    return $usuario->$dato_resultado >= $rango[0] && $usuario->$dato_resultado <= $rango[1];
                });
                $alto =  $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode('*', $usuario->$dato_referencia);
                    if(count($rango) != 2){
                        return false;
                    }
                    return $usuario->$dato_resultado > $rango[1];
                });
                break;
            case 'colesterol':
                $bajo = $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    return false;
                });
                $normal = $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode(' ', $usuario->colesterol_referencia);

                    return $usuario->colesterol_resultado <= $rango[2];
                });
                $alto =  $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode(' ', $usuario->colesterol_referencia);
                    return $usuario->colesterol_resultado > $rango[2];
                });
                break;
            default:
                $bajo = $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode('-', $usuario->$dato_referencia);
                    if(count($rango) != 2){
                        return false;
                    }
                    return $usuario->$dato_resultado < $rango[0];
                });
                $normal = $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode('-', $usuario->$dato_referencia);
                    if(count($rango) != 2){
                        return false;
                    }
                    return $usuario->$dato_resultado >= $rango[0] && $usuario->$dato_resultado <= $rango[1];
                });
                $alto =  $usuarios->filter(function($usuario) use($dato_referencia, $dato_resultado){
                    $rango = explode('-', $usuario->$dato_referencia);
                    if(count($rango) != 2){
                        return false;
                    }
                    return $usuario->$dato_resultado > $rango[1];
                });
                break;
        }

        return [
            $bajo->count(),
            $normal->count(),
            $alto->count()
        ];
    }

    public function obtenerNumeroDatos(Collection $datos){
        $resultado = [];

        $datos->map(function($dato) use(&$resultado){
            array_push($resultado, $dato->count());
            return $dato;
        });

        return $resultado;
    }

    public function GetSintomasBajos($usuarios){
        $glucosaNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->glucosa_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->glucosa_referencia);
            return $usuario->glucosa_resultado < $rango[0];
        });
        $trigliceridosNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->trigliceridos_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->trigliceridos_referencia);
            if(count($rango) != 2){
                return false;
            }
            return $usuario->trigliceridos_resultado < $rango[0];
        });
        $hemoglobinaNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->hemoglobina_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('*', $usuario->hemoglobina_referencia);
            try{
                $usuario->hemoglobina_referencia = $rango[0].'-'.$rango[1];
            }catch(\Throwable $error){
                $rango = explode('-', $usuario->hemoglobina_referencia);
            }
            return $usuario->hemoglobina_resultado < $rango[0];
        });
        $leucocitosNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->leucocitos_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->leucocitos_referencia);
            return $usuario->leucocitos_resultado < $rango[0];
        });
        $plaquetasNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->plaquetas_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->plaquetas_referencia);
            return $usuario->plaquetas_resultado < $rango[0];
        });

        return new Collection([
            'Glucosa' => $glucosaNormal,
            'Trigliceridos' => $trigliceridosNormal,
            'Colesterol' => new Collection([]),
            'Hemoglobina' => $hemoglobinaNormal,
            'Leucocitos' => $leucocitosNormal,
            'Plaquetas' => $plaquetasNormal,
        ]);
    }
    public function GetSintomasNormales($usuarios){
        $glucosaNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->glucosa_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->glucosa_referencia);
            return $usuario->glucosa_resultado >= $rango[0] && $usuario->glucosa_resultado <= $rango[1];
        });
        $trigliceridosNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->trigliceridos_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->trigliceridos_referencia);
            if(count($rango) != 2){
                return false;
            }
            return $usuario->trigliceridos_resultado >= $rango[0] && $usuario->trigliceridos_resultado <= $rango[1];
        });
        $colesterolNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->colesterol_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode(' ', $usuario->colesterol_referencia);
            return $usuario->colesterol_resultado <= $rango[2];
        });
        $hemoglobinaNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->hemoglobina_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('*', $usuario->hemoglobina_referencia);
            try{
                $usuario->hemoglobina_referencia = $rango[0].'-'.$rango[1];
            }catch(\Throwable $error){
                $rango = explode('-', $usuario->hemoglobina_referencia);
            }

            return $usuario->hemoglobina_resultado >= $rango[0] && $usuario->hemoglobina_resultado <= $rango[1];
        });
        $leucocitosNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->leucocitos_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->leucocitos_referencia);
            return $usuario->leucocitos_resultado >= $rango[0] && $usuario->leucocitos_resultado <= $rango[1];
        });
        $plaquetasNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->plaquetas_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->plaquetas_referencia);
            return $usuario->plaquetas_resultado >= $rango[0] && $usuario->plaquetas_resultado <= $rango[1];
        });

        return new Collection([
            'Glucosa' => $glucosaNormal,
            'Trigliceridos' => $trigliceridosNormal,
            'Colesterol' => $colesterolNormal,
            'Hemoglobina' => $hemoglobinaNormal,
            'Leucocitos' => $leucocitosNormal,
            'Plaquetas' => $plaquetasNormal
        ]);
    }
    public function GetSintomasAltos($usuarios){
        $glucosaNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->glucosa_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->glucosa_referencia);
            return $usuario->glucosa_resultado > $rango[1];
        });
        $trigliceridosNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->trigliceridos_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->trigliceridos_referencia);
            if(count($rango) != 2){
                return false;
            }
            return $usuario->trigliceridos_resultado > $rango[1];
        });
        $colesterolNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->colesterol_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode(' ', $usuario->colesterol_referencia);
            return $usuario->colesterol_resultado > $rango[2];
        });
        $hemoglobinaNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->hemoglobina_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('*', $usuario->hemoglobina_referencia);
            try{
                $usuario->hemoglobina_referencia = $rango[0].'-'.$rango[1];
            }catch(\Throwable $error){
                $rango = explode('-', $usuario->hemoglobina_referencia);
            }
            return $usuario->hemoglobina_resultado > $rango[1];
        });
        $leucocitosNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->leucocitos_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->leucocitos_referencia);
            return $usuario->leucocitos_resultado > $rango[1];
        });
        $plaquetasNormal = $usuarios->filter(function($usuario){
            $usuario->resultado = $usuario->plaquetas_resultado;
            if($usuario->resultado==null){
                return false;
            }
            $rango = explode('-', $usuario->plaquetas_referencia);
            return $usuario->plaquetas_resultado > $rango[1];
        });

        return new Collection([
            'Glucosa' => $glucosaNormal,
            'Trigliceridos' => $trigliceridosNormal,
            'Colesterol' => $colesterolNormal,
            'Hemoglobina' => $hemoglobinaNormal,
            'Leucocitos' => $leucocitosNormal,
            'Plaquetas' => $plaquetasNormal
        ]);
    }

    public function examenes(){
        $permisoTodas = Auth::user()->hasRole(['admin', 'Doctora']);
        if($permisoTodas){
            $areas = Area::where('division_id', 'DX')
                        ->where('area_clave', '!=', 'DXSU')
                        ->get();
        }
        else{
            $areas = Area::where('area_clave', Auth::user()->datos->area)->get();
        }
        $fechas = ProSalud::selectRaw('YEAR(fecha_toma) as fecha')
                                ->groupByRaw('YEAR(fecha_toma)')
                                ->orderByRaw('YEAR(fecha_toma) DESC')->get()->pluck('fecha');
        return view('prosalud.examenes', [
            'areas' => $areas,
            'fechas' => $fechas,
            'permisoTodas' => $permisoTodas
        ]);
    }

    public function filtrarSubareas(Request $request){
        $data = $request->all();
        $area = $data['area'];
        $subareas = Subarea::where('area_id', $area)
        ->select('subarea_clave', 'subarea_nombre')
        ->get();

        $subareaFiltro = $request->input('subarea');
        //obtener los rpes de DatosUser según los filtros
        $RpeUsers = DatosUser::where('area', $area)
                    ->where('subarea', $subareaFiltro)
                    ->pluck('rpe');
        $prosaludDatos = ProSalud::whereIn('rpe', $RpeUsers)
                ->get();
        $RpeUsersCount = count($RpeUsers);
        $resultadoSi = count($prosaludDatos);
        $resultadoNo = $RpeUsersCount - $resultadoSi;

        return response()->json([
            'subareas' => $subareas,
            'RpeUsers' => $RpeUsers,
            'prosaludDatos' => $prosaludDatos,
            'claveSubarea' => $subareaFiltro,
            'resultadoSi' => $resultadoSi,
            'resultadoNo' => $resultadoNo,
        ]);
    }

    public function filtrarFechas(Request $request){
        $data = $request->all();
        $fechaFiltro = $data['year'];
        $year = ProSalud::whereYear('fecha_toma', $fechaFiltro)->get();
        $countYear = count($year);

        return response()->json([
            'year' => $year,
            'fechaFiltro' => $fechaFiltro,
            'countYear' => $countYear,
        ]);
    }
    public function graficaHistorial(){
        $areas = Area::with(['subareas.incapacidades'])->where('division_id', 'DX')->get();
        $role = false;
        $numeroProsalud = ProSalud::where('zona', Auth::user()->datos->area)->count();

         $años = ProSalud::select(DB::raw('YEAR(fecha_Toma) as año'))
                ->orderBy('año', 'desc')
                ->distinct()
                ->limit(5)
                ->pluck('año')
                ->sort()
                ->values()
                ->toArray();

        $resultados = [
        'glucosa_resultado' => [],
        'trigliceridos_resultado' => [],
        'colesterol_resultado' => [],
        'hemoglobina_resultado' => [],
        'leucocitos_resultado' => [],
        'plaquetas_resultado' => [],
        ];
        if(Auth::user()->hasRole('RecursosHumanos')){
            $role = true;
            $area = Area::where('area_clave', Auth::user()->datos->area)->first();
            foreach ($años as $año) {
                $usuarios = ProSalud::whereYear('fecha_Toma', $año)->where('zona', $area)->get();
                $bajos = $this->obtenerNumeroDatos($this->GetSintomasBajos($usuarios));
                $resultados['glucosa_bajo'][] = $bajos[0];
                $resultados['trigliceridos_bajo'][] = $bajos[1];
                $resultados['colesterol_bajo'][] = $bajos[2];
                $resultados['hemoglobina_bajo'][] = $bajos[3];
                $resultados['leucocitos_bajo'][] = $bajos[4];
                $resultados['plaquetas_bajo'][] = $bajos[5];
                $normales = $this->obtenerNumeroDatos($this->GetSintomasNormales($usuarios));
                $resultados['glucosa_normal'][] = $normales[0];
                $resultados['trigliceridos_normal'][] = $normales[1];
                $resultados['colesterol_normal'][] = $normales[2];
                $resultados['hemoglobina_normal'][] = $normales[3];
                $resultados['leucocitos_normal'][] = $normales[4];
                $resultados['plaquetas_normal'][] = $normales[5];
                $altos = $this->obtenerNumeroDatos($this->GetSintomasAltos($usuarios));
                $resultados['glucosa_alto'][] = $altos[0];
                $resultados['trigliceridos_alto'][] = $altos[1];
                $resultados['colesterol_alto'][] = $altos[2];
                $resultados['hemoglobina_alto'][] = $altos[3];
                $resultados['leucocitos_alto'][] = $altos[4];
                $resultados['plaquetas_alto'][] = $altos[5];
            }
        }else{
            foreach ($años as $año) {
                $usuarios = ProSalud::whereYear('fecha_Toma', $año)->get();
                $bajos = $this->obtenerNumeroDatos($this->GetSintomasBajos($usuarios));
                $resultados['glucosa_bajo'][] = $bajos[0];
                $resultados['trigliceridos_bajo'][] = $bajos[1];
                $resultados['colesterol_bajo'][] = $bajos[2];
                $resultados['hemoglobina_bajo'][] = $bajos[3];
                $resultados['leucocitos_bajo'][] = $bajos[4];
                $resultados['plaquetas_bajo'][] = $bajos[5];
                $normales = $this->obtenerNumeroDatos($this->GetSintomasNormales($usuarios));
                $resultados['glucosa_normal'][] = $normales[0];
                $resultados['trigliceridos_normal'][] = $normales[1];
                $resultados['colesterol_normal'][] = $normales[2];
                $resultados['hemoglobina_normal'][] = $normales[3];
                $resultados['leucocitos_normal'][] = $normales[4];
                $resultados['plaquetas_normal'][] = $normales[5];
                $altos = $this->obtenerNumeroDatos($this->GetSintomasAltos($usuarios));
                $resultados['glucosa_alto'][] = $altos[0];
                $resultados['trigliceridos_alto'][] = $altos[1];
                $resultados['colesterol_alto'][] = $altos[2];
                $resultados['hemoglobina_alto'][] = $altos[3];
                $resultados['leucocitos_alto'][] = $altos[4];
                $resultados['plaquetas_alto'][] = $altos[5];
            }
        }
        return view('estadisticas.prosalud.historial', compact('años', 'resultados'), ['areas' => $areas, 'role' => $role, 'numeroProsalud' => $numeroProsalud]);
    }
    public function filtrarArea(Request $request)
    {
        $area = $request->input('area');
        info($area);
        $indice = $request->input('indice');
        $años = ProSalud::select(DB::raw('YEAR(fecha_Toma) as año'))
                ->orderBy('año', 'desc')
                ->distinct()
                ->limit(5)
                ->pluck('año')
                ->sort()
                ->values()
                ->toArray();

        $resultados = [
        'glucosa_resultado' => [],
        'trigliceridos_resultado' => [],
        'colesterol_resultado' => [],
        'hemoglobina_resultado' => [],
        'leucocitos_resultado' => [],
        'plaquetas_resultado' => [],
        ];
        if($area != 0){
            foreach ($años as $año) {
                $usuarios = ProSalud::whereYear('fecha_Toma', $año)->where('zona', $area)->get();
                if($indice == 'bajo'){
                    $bajos = $this->obtenerNumeroDatos($this->GetSintomasBajos($usuarios));
                    $resultados['glucosa_resultado'][] = $bajos[0];
                    $resultados['trigliceridos_resultado'][] = $bajos[1];
                    $resultados['colesterol_resultado'][] = $bajos[2];
                    $resultados['hemoglobina_resultado'][] = $bajos[3];
                    $resultados['leucocitos_resultado'][] = $bajos[4];
                    $resultados['plaquetas_resultado'][] = $bajos[5];
                }elseif($indice == 'normal'){
                    $normales = $this->obtenerNumeroDatos($this->GetSintomasNormales($usuarios));
                    $resultados['glucosa_resultado'][] = $normales[0];
                    $resultados['trigliceridos_resultado'][] = $normales[1];
                    $resultados['colesterol_resultado'][] = $normales[2];
                    $resultados['hemoglobina_resultado'][] = $normales[3];
                    $resultados['leucocitos_resultado'][] = $normales[4];
                    $resultados['plaquetas_resultado'][] = $normales[5];
                }else{
                    $altos = $this->obtenerNumeroDatos($this->GetSintomasAltos($usuarios));
                    $resultados['glucosa_resultado'][] = $altos[0];
                    $resultados['trigliceridos_resultado'][] = $altos[1];
                    $resultados['colesterol_resultado'][] = $altos[2];
                    $resultados['hemoglobina_resultado'][] = $altos[3];
                    $resultados['leucocitos_resultado'][] = $altos[4];
                    $resultados['plaquetas_resultado'][] = $altos[5];
                }
            }
        }else{
            foreach ($años as $año) {
                $usuarios = ProSalud::whereYear('fecha_Toma', $año)->get();
                if($indice == 'bajo'){
                    $bajos = $this->obtenerNumeroDatos($this->GetSintomasBajos($usuarios));
                    $resultados['glucosa_resultado'][] = $bajos[0];
                    $resultados['trigliceridos_resultado'][] = $bajos[1];
                    $resultados['colesterol_resultado'][] = $bajos[2];
                    $resultados['hemoglobina_resultado'][] = $bajos[3];
                    $resultados['leucocitos_resultado'][] = $bajos[4];
                    $resultados['plaquetas_resultado'][] = $bajos[5];
                }elseif($indice == 'normal'){
                    $normales = $this->obtenerNumeroDatos($this->GetSintomasNormales($usuarios));
                    $resultados['glucosa_resultado'][] = $normales[0];
                    $resultados['trigliceridos_resultado'][] = $normales[1];
                    $resultados['colesterol_resultado'][] = $normales[2];
                    $resultados['hemoglobina_resultado'][] = $normales[3];
                    $resultados['leucocitos_resultado'][] = $normales[4];
                    $resultados['plaquetas_resultado'][] = $normales[5];
                }else{
                    $altos = $this->obtenerNumeroDatos($this->GetSintomasAltos($usuarios));
                    $resultados['glucosa_resultado'][] = $altos[0];
                    $resultados['trigliceridos_resultado'][] = $altos[1];
                    $resultados['colesterol_resultado'][] = $altos[2];
                    $resultados['hemoglobina_resultado'][] = $altos[3];
                    $resultados['leucocitos_resultado'][] = $altos[4];
                    $resultados['plaquetas_resultado'][] = $altos[5];
                }
            }
        }
        info($resultados);
        return response()->json(['años' => $años, 'resultados' => $resultados]);
    }

    public function filtrarExamenes(Request $request){
        $data = $request->all();
        $fechaObjetivo = $data['year'];
        $areaObjetivo = $data['area'];
        $areas = Area::where('division_id', 'DX')
                    ->where('area_clave', '!=', 'DXSU')
                    ->get()->pluck('area_clave');
        if($areaObjetivo == 'all'){
            $usuariosConExamen = ProSalud::whereYear('fecha_toma', $fechaObjetivo)
                                ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                                ->get();
        }else{
            $usuariosConExamen = ProSalud::whereYear('fecha_toma', $fechaObjetivo)
                                ->where('zona', $areaObjetivo)
                                ->join('datosusers', 'prosalud.rpe', '=', 'datosusers.rpe')
                                ->get();
        }

        $rpesConExamen = $usuariosConExamen->groupBy('rpe')->keys()->values();

        $usuariosSinExamen = $areaObjetivo != 'all' ?
                                Datosuser::where('area', $areaObjetivo)
                                ->whereNotIn('rpe', $rpesConExamen)
                                ->get()
                            :
                                Datosuser::whereIn('area', $areas)
                                ->whereNotIn('rpe', $rpesConExamen)
                                ->get()
                            ;
        $usuariosConExamen = Datosuser::whereNotIn('rpe', $usuariosSinExamen->groupBy('rpe')->keys()->values())
                                ->whereIn('area', $usuariosSinExamen->groupBy('area')->keys()->values())
                                ->get();

        $total =  $areaObjetivo != 'all' ?
                        Datosuser::where('area', $areaObjetivo)
                        ->get()->count()
                    :
                        Datosuser::whereIn('area', $areas)
                        ->get()->count()
                    ;

        return response()->json([
            'usuariosConExamen' => $usuariosConExamen,
            'usuariosSinExamen' => $usuariosSinExamen,
            'total' => $total
        ]);
    }

}
