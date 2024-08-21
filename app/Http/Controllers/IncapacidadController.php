<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Models\Area;
use App\Models\User;
use App\Models\Subarea;
use App\Models\Division;
use Carbon\Carbon;
use App\Models\Datosuser;
use App\Models\Incapacidad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\BIENESTARcorreos;
use App\Models\ArchivoGeneral;
use App\Models\FileType;
use App\Models\UbicacionesArchivo;
use App\Models\Padecimiento;
use App\Models\UnidadesMedicas;
use App\Models\UsuarioUnidad;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class IncapacidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:incapacidad.index')->only('index', 'show');
        $this->middleware('can:incapacidad.create')->only('create', 'store');
        $this->middleware('can:incapacidad.edit')->only('edit', 'update');
        $this->middleware('can:incapacidad.delete')->only('destroy');
        $this->middleware('can:incapacidad.autorizar')->only('autorizar', 'rechazar');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $padecimientos = Padecimiento::all();
    $areas = Auth::user()->datos->getDivision->areas;
    $subareas = Auth::user()->datos->getArea->subareas;

        //$incapacidades = Incapacidad::all();

        $datosuser = Datosuser::with('incapacidades')
            ->where('division', Auth::user()->datos->getDivision->division_clave)
            ->where('area', Auth::user()->datos->getArea->area_clave)->get();

        $incapacidades = $datosuser->flatMap(function ($datosuser) {
            return $datosuser->incapacidades;
        });

    $user_area = Auth::user()->datos->area;


        $incapacidades = Incapacidad::whereRaw('LOWER(subarea) LIKE ?', ['%' . strtolower($user_area) . '%'])
            ->with('user', 'file', 'sub')->get();


        $totalRegistros = $incapacidades->count(); // Contar el total de registros
        $dias_autorizados = $incapacidades->sum('dias_autorizados');

        return view('incapacidades.index', [
            'incapacidades' => $incapacidades,
            'padecimientos' => $padecimientos,
            'areas' => $areas,
            'subareas' => $subareas,
            'dias_autorizados' => $dias_autorizados,
            'totalRegistros' => $totalRegistros // Pasar el total de registros a la vista
        ]);
    }

    public function indexByRPE($rpe)
    {
        $user = Auth::user()->datos;

    // Asegúrate de que las relaciones existan
    $divisionClave = optional($user->getDivision)->division_clave;
    $areaClave = optional($user->getArea)->area_clave;

    // Busca los datos del usuario
    $datosuser = Datosuser::with('incapacidades')
        ->where('rpe', '=', $rpe)
        ->where('division', $divisionClave)
        ->where('area', $areaClave)
        ->first();

        $nombreCompleto = $datosuser->nombre . " " . $datosuser->paterno . " " . $datosuser->materno;
    if (!$datosuser) {
        return redirect()->back()->with('error', 'No se encontraron registros para el RPE proporcionado.');
    }


    $incapacidades = $datosuser->incapacidades;
    $totalRegistros = $incapacidades->count();
    $dias_autorizados = $incapacidades->sum('dias_autorizados');

    $incapacidadesJson = $incapacidades->map(function($incapacidad) {
        return [
            'start' => $incapacidad->fecha_inicio,
            'end' => Carbon::parse($incapacidad->fecha_fin)->addDay()->format('Y-m-d'),
            'display' => "background",
        ];
    })->toArray();


    if (!is_array($incapacidadesJson)) {
        dd('No es un array', $incapacidadesJson);
    }

    return view('incapacidades.indexrpe', [
        'incapacidades' => $incapacidades,
        'padecimientos' => Padecimiento::all(),
        'areas' => optional($user->getDivision)->areas ?: collect(),
        'subareas' => optional($user->getArea)->subareas ?: collect(),
        'dias_autorizados' => $dias_autorizados,
        'totalRegistros' => $totalRegistros,
        'rpe' => $rpe,
        'incapacidadesJson' => $incapacidadesJson,
        'nombreCompleto' => $nombreCompleto
    ]);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->hasAnyRole(['admin', 'Doctora']) && !isset($request->rpe)) {
            return redirect()->route('salud.inicio');
        }
        $datosuser = Datosuser::where('rpe', $request->rpe)->first();
        $nombre = $datosuser ? implode(' ', $datosuser->only(['nombre', 'paterno', 'materno'])) : '';
        $dias_acumulados = 0;
        $padecimientos = Padecimiento::orderBy('padecimiento_nombre', 'asc')->get();
        $incapacidades = Incapacidad::with('padecimientos')->get();
        $unidades = UnidadesMedicas::all();
        if ($datosuser) {
            $datosuser['datosUnidad'] = UsuarioUnidad::where('rpe', $request->rpe)->first();
            $ultimaIncapacidad = Incapacidad::where('rpe', $datosuser->rpe)->latest()->first();
            if ($ultimaIncapacidad) {
                $dias_acumulados = $ultimaIncapacidad->dias_acumulados;
            }
        }
        return view('incapacidades.crear', ['datosuser' => $datosuser, 'dias_acumulados' => $dias_acumulados, 'nombre' => $nombre, 'padecimientos' => $padecimientos, 'incapacidades' => $incapacidades, 'unidades' => $unidades]);
    }

    public function search(Request $request)
    {
        $datosuser = Datosuser::where('rpe', $request->rpe)->first();
        $datosuser->nombreCompleto = $datosuser->nombre . " " . $datosuser->paterno . " " . $datosuser->materno;

        // Obtener la Unidad Médica "principal" del usuario
        $datosUMFusuario = UsuarioUnidad::where('rpe', $request->rpe)->first();

        return response()->json([
            'datosuser' => $datosuser,
            'datosUMFusuario' => $datosUMFusuario
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'certificado' => 'required|min:8|max:12',
            'tipo' => 'required',
            'ramo_de_seguro' => 'required',
            'dias_autorizados' => 'required',
            'dias_acumulados' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_Inicio',
            'nombre_doctor' => 'required',
            'matricula_doctor' => 'required',
            'rpe' => 'required',
            'diagnostico' => 'required',
            'archivo' => 'file|mimes:pdf|required',
            'padecimiento' => 'required',
            'unidad_medica' => 'required|integer|exists:unidades_medicas,id',
            'consultorio' => 'required|integer',
            'turno' => 'required',
        ]);

        if ($request->has('archivo')) {
            $registroArchivo = $this->crearArchivoIncapacidad($request->archivo);
        }
        $rpe = strtoupper($request->rpe);
        $ultimaIncapacidad = Incapacidad::where('rpe', $request->rpe)->latest()->first();
        $dias_acumulados = 0;
        if ($ultimaIncapacidad) {
            $dias_acumulados = $ultimaIncapacidad->dias_acumulados;
        }

        $dias_acumulados = 0;
        $fecha_inmediata_anterior = Carbon::parse($request->fecha_inicio)->subDay();


        // Buscar la incapacidad inmediata anterior
        $incapacidadAnterior = Incapacidad::where('rpe', $request->rpe)
            ->where('fecha_fin', $fecha_inmediata_anterior)
            ->first();

        if ($incapacidadAnterior) {
            // Incrementa el contador de días acumulados si son consecutivos
            if ($incapacidadAnterior->dias_acumulados != 0) {
                //Si ya hay más de una incapacidad recurrente, se toman los acumulados
                $dias_acumulados = $request->dias_autorizados + $incapacidadAnterior->dias_acumulados;
            } else {
                //Si es la primera consecutiva, se toman los autorizados
                $dias_acumulados = $request->dias_autorizados + $incapacidadAnterior->dias_autorizados;
            }
        }

        $user_subarea = Datosuser::where('rpe', $rpe)->value('subarea');
        Incapacidad::create([
            'certificado' => $request->certificado,
            'tipo' => $request->tipo,
            'ramo_de_seguro' => $request->ramo_de_seguro,
            'dias_autorizados' => $request->dias_autorizados,
            'dias_acumulados' => $dias_acumulados,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'nombre_doctor' => $request->nombre_doctor,
            'matricula_doctor' => $request->matricula_doctor,
            'rpe' => strtoupper($request->rpe),
            'subarea' => $user_subarea,
            'diagnostico' => $request->diagnostico,
            'obervaciones' => $request->observaciones,
            'archivo' => $registroArchivo?->id ?? null,
            'padecimiento' => $request->padecimiento,
            'umf_id' => $request->unidad_medica,
            'consultorio' => $request->consultorio,
            'turno' => $request->turno,
        ]);

        $datosuser = Datosuser::where('rpe', $request->rpe)->first();
        $nombre = $datosuser ? implode(' ', $datosuser->only(['nombre', 'paterno', 'materno'])) : '';

        $vista = 'incapacidad';
        $email = User::where('rpe', $datosuser->rpe)->first()->email;

        Mail::to($email)->send(new BIENESTARcorreos(
            $request->dias_autorizados,
            $nombre,
            $request->fecha_inicio,
            $request->fecha_fin,
            $request->ramo_de_seguro,
            $request->nombre_doctor,
            $vista
        ));

        return redirect()->route('incapacidades.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $incapacidad = Incapacidad::where('id', $id)->with('user')->firstOrFail();
        $usuario = $incapacidad->user;
        $nombre = $usuario ? implode(' ', $usuario->only(['nombre', 'paterno', 'materno'])) : '';
        $archivoRelacionado = $incapacidad->file;

        return view('incapacidades.show', ['incapacidad' => $incapacidad, 'datosuser' => $usuario,  'nombre' => $nombre, 'dias_acumulados' => $incapacidad->dias_acumulados, 'archivo' => $archivoRelacionado]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $incapacidad = Incapacidad::where('id', $id)->with('user')->firstOrFail();
        $usuario = $incapacidad->user;
        $usuario['datosUnidad'] = UsuarioUnidad::where('rpe', $usuario->rpe)->first();
        $nombre = $usuario ? implode(' ', $usuario->only(['nombre', 'paterno', 'materno'])) : '';
        $archivoRelacionado = $incapacidad->file;
        $padecimientos = Padecimiento::orderBy('padecimiento_nombre', 'asc')->get();
        $unidades = UnidadesMedicas::all();

    return view('incapacidades.editar', ['incapacidad' => $incapacidad, 'datosuser' => $usuario,  'nombre' => $nombre, 'dias_acumulados' => $incapacidad->dias_acumulados, 'archivo' => $archivoRelacionado, 'unidades' => $unidades, 'padecimientos' => $padecimientos]);
    }
    public function autorizar($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        $incapacidad->estatus = 'Aprobado';
        $incapacidad->save();

        return redirect()->route('incapacidades.index')->with('success', 'Incapacidad autorizada.');
    }

    public function rechazar($id)
    {
        $incapacidad = Incapacidad::findOrFail($id);
        $incapacidad->estatus = 'Rechazado';
        $incapacidad->save();

        return redirect()->route('incapacidades.index')->with('success', 'Incapacidad rechazada.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $incapacidadOriginal = Incapacidad::FindOrFail($id);

        $campos = $request->validate([
            'certificado' => 'required',
            'tipo' => 'required',
            'ramo_de_seguro' => 'required',
            'dias_autorizados' => 'required',
            'dias_acumulados' => 'required',
            'fecha_inicio' => 'required|date|after_or_equal:min_date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'nombre_doctor' => 'required',
            'matricula_doctor' => 'required',
            'rpe' => 'required',
            'diagnostico' => 'required',
            'archivo' => 'file|mimes:pdf',
            'padecimiento' => 'required',
            'unidad_medica' => 'required|integer|exists:unidades_medicas,id',
            'consultorio' => 'required|integer',
            'turno' => 'required',
        ]);

        $request['rpe'] = strtoupper($request->rpe);

        if ($request->has('archivo')) {
            $archivoOriginal = $incapacidadOriginal->file;

            if ($archivoOriginal) {
                $hash = $archivoOriginal->hash;
                $extension = $archivoOriginal->extension->extension;


                $nuevoArchivo = $request->archivo;
                Storage::disk('public')->putFileAs('incapacidades', $nuevoArchivo, $hash . $extension);


                $archivoOriginal->fill(['nombre_archivo' => $nuevoArchivo->getClientOriginalName()]);
                $archivoOriginal->save();
                $campos['archivo'] = $archivoOriginal->id;
            } else {
                $registroArchivo = $this->crearArchivoIncapacidad($request->archivo);
                $campos['archivo'] = $registroArchivo->id;
            }
        }



        $incapacidadOriginal->fill($campos);
        $observ = $request?->observaciones ?? null;
        if ($observ) {
            $incapacidadOriginal->observaciones = $observ;
        }
        $incapacidadOriginal->save();

        if (isset($request->origen)) {
            return response()->json(
                [
                    'success' => true,
                ]
            );
        } else {
            return redirect()->route('incapacidades.show', $incapacidadOriginal->id)->with('message', 'Se actualizo la información correctamente!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $incapacidad = Incapacidad::findOrFail($id);

        if ($archivoRelacionado = $incapacidad->file) {
            if (file_exists($archivoRelacionado->getFilePath())) {
                if (File::delete($archivoRelacionado->getFilePath())) {
                    $archivoRelacionado->delete();
                }
            }
        }

        $incapacidad->delete();

        if (isset($request->origen)) {
            return response()->json(
                [
                    'success' => true,
                ]
            );
        } else {
            return redirect()->route('incapacidades.index')->with('success', 'Incapacidad eliminada con éxito');
        }
    }

    public function filtrarIncapacidades(Request $request)
    {
        $division = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $tipo = $request->tipo;
        $ramo = $request->ramo;
        $fecha = $request->fecha;
        $fechaFin = $request->fechaf;
        $estatus = $request->estatus;
        $padecimiento = $request->padecimiento;

        // Iniciar la consulta base
        $query = Incapacidad::whereRaw('LOWER(subarea) LIKE ?', ['%' . strtolower($subarea == 0 ? ($area == 0 ? $division : $area) : $subarea) . '%'])
            ->with('user', 'file', 'sub.area', 'padecimientos')
            ->when($tipo != '0', function ($query) use ($tipo) {
                return $query->where('tipo', $tipo);
            })
            ->when($ramo != '0', function ($query) use ($ramo) {
                return $query->where('ramo_de_seguro', $ramo);
            })
            ->when($estatus != '0', function ($query) use ($estatus) {
                return $query->where('estatus', $estatus);
            })
            ->when($padecimiento != '0', function ($query) use ($padecimiento) {
                return $query->where('padecimiento', $padecimiento);
            })
            //Incapacidades que se encuentran dentro del rango solicitado por el usuario
            ->when($fecha != '', function ($query) use ($fecha) {
                return $query->where('fecha_inicio', '>=', $fecha);
            })
            ->when($fechaFin != '', function ($query) use ($fechaFin) {
                return $query->where('fecha_inicio', '<=', $fechaFin);
            });


        $incapacidades = $query->get();
        $totalDiasAutorizados = $query->sum('dias_autorizados');
        $incapacidadAutorizar = auth()->user()->can('incapacidad.autorizar');
        $totalRegistros = $query->count();

        return response()->json([
            'incapacidades' => $incapacidades,
            'total_dias_autorizados' => $totalDiasAutorizados,
            'total_registros' => $totalRegistros,
            'incapacidadAutorizar' =>  $incapacidadAutorizar,
            'success' => true,
        ]);
    }

    private function crearArchivoIncapacidad($archivo)
    {
        // Obtener donde guardar archivo
        $carpeta = UbicacionesArchivo::where('categoria', 'incapacidades')->first();

        // Obtener extensión del archivo
        $extension = FileType::where('extension', '.' . $archivo->getClientOriginalExtension())->first();

        // Si no existe la extensión en la BD
        if (!$extension) {
            $extension = FileType::create(['extension' => ('.' . $archivo->getClientOriginalExtension())]);
        }

        $hash = (string) Str::random(20);

        // Almacenar archivo con hash generado
        $archivo->move(public_path() . '/' . $carpeta->carpeta, $hash . $extension->extension);

        // Almacenar en modelo y obtener registro
        return ArchivoGeneral::create([
            'id_ruta' => $carpeta->id,
            'hash' => $hash,
            'nombre_archivo' => $archivo->getClientOriginalName(),
            'tipo_archivo' => $extension->id,
        ]);
    }

    public function padecimientosGrafica()
    {
        $areas = Area::where('division_id', 'DX')->get();
        $role = false;
        $fechaInicio = Carbon::now();
        $fechaFin = Carbon::now();
        if(Auth::user()->hasRole('RecursosHumanos')){
            $area = Auth::user()->datos->area;
            $role = true;
            $datos = Padecimiento::leftJoin('incapacidades', function ($join) use ($fechaInicio, $fechaFin, $area) {
                $join->on('padecimientos.id', '=', 'incapacidades.padecimiento')
                    ->whereRaw('LOWER(incapacidades.subarea) LIKE ?', ['%' . strtolower($area) . '%'])
                    ->where(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->whereBetween('incapacidades.fecha_Inicio', [$fechaInicio, $fechaFin])
                            ->orWhereBetween('incapacidades.fecha_Fin', [$fechaInicio, $fechaFin]);
                    });
            })
                ->select('padecimientos.padecimiento_nombre', \DB::raw('COUNT(incapacidades.id) as total'))
                ->groupBy('padecimientos.padecimiento_nombre')
                ->get();
            $incapacidadesFiltradas = Incapacidad::whereRaw('LOWER(incapacidades.subarea) LIKE ?', ['%' . strtolower($area) . '%'])
                ->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_Inicio', [$fechaInicio, $fechaFin])
                        ->orWhereBetween('fecha_Fin', [$fechaInicio, $fechaFin]);
                })
                ->get();
        }else{
            $datos = Padecimiento::leftJoin('incapacidades', function($join) use ($fechaInicio, $fechaFin) {
                $join->on('padecimientos.id', '=', 'incapacidades.padecimiento')
                    ->where(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->whereBetween('incapacidades.fecha_Inicio', [$fechaInicio, $fechaFin])
                            ->orWhereBetween('incapacidades.fecha_Fin', [$fechaInicio, $fechaFin]);
                    });
            })
                ->select('padecimientos.padecimiento_nombre', \DB::raw('COUNT(incapacidades.id) as total'))
                ->groupBy('padecimientos.padecimiento_nombre')
                ->get();
            $incapacidadesFiltradas = Incapacidad::where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_Inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_Fin', [$fechaInicio, $fechaFin]);
            })
                ->get();
        }
        $numeroIncapacidades = $incapacidadesFiltradas->count();

        $labels = $datos->pluck('padecimiento_nombre');
        $valores = $datos->pluck('total');

        return view('estadisticas.incapacidades.padecimientos', compact('labels', 'valores',), ['areas' => $areas, 'numeroIncapacidades' => $numeroIncapacidades, 'role' => $role]);
    }

    public function incapacidadesGrafica()
    {
        $areas = Area::with(['subareas.incapacidades'])->where('division_id', 'DX')->get();
        $padecimientos = Padecimiento::all();
        $fechaInicio = Carbon::now();
        $fechaFin = Carbon::now();
        $role = false;
        $labels = [];
        $valores = [];
        $numeroIncapacidades = Incapacidad::count();
        if(Auth::user()->hasRole('RecursosHumanos')){
            $area = Auth::user()->datos->area;
            $area = Area::where('area_clave', $area)->first();
            $role = true;
            $subareasIds = $area->subareas->pluck('subarea_clave')->toArray();

            $incapacidades = Incapacidad::whereIn('subarea', $subareasIds)
                ->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                        ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                })
                ->get();

            foreach ($area->subareas as $subarea) {
                $count = $incapacidades->where('subarea', $subarea->subarea_clave)->count();
                $labels[] = $subarea->subarea_nombre;
                $valores[] = $count;
            }
            $numeroIncapacidades = $incapacidades->count();
        }else{
            $incapacidades = Incapacidad::where(function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
            })
                ->get();
            $areas = Area::with('subareas')->where('division_id', 'DX')->get();

            foreach ($areas as $area) {
                $count = 0;
                foreach ($area->subareas as $subarea) {
                    $count += $incapacidades->where('subarea', $subarea->subarea_clave)->count();
                }
                $labels[] = $area->area_nombre;
                $valores[] = $count;
            }
            $numeroIncapacidades = $incapacidades->count();
        }

        return view('estadisticas.incapacidades.incapacidades', compact('labels', 'valores',), ['areas' => $areas, 'numeroIncapacidades' => $numeroIncapacidades, 'padecimientos' => $padecimientos, 'role' => $role]);
    }
    public function filtrarGrafica(Request $request)
    {
        $fechaInicio = $request->input('fecha_Inicio');
        $fechaFin = $request->input('fecha_Fin');
        $area = $request->input('area');
        if ($area != 0) {
            $datos = Padecimiento::leftJoin('incapacidades', function ($join) use ($fechaInicio, $fechaFin, $area) {
                $join->on('padecimientos.id', '=', 'incapacidades.padecimiento')
                    ->whereRaw('LOWER(incapacidades.subarea) LIKE ?', ['%' . strtolower($area) . '%'])
                    ->where(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->whereBetween('incapacidades.fecha_Inicio', [$fechaInicio, $fechaFin])
                            ->orWhereBetween('incapacidades.fecha_Fin', [$fechaInicio, $fechaFin]);
                    });
            })
                ->select('padecimientos.padecimiento_nombre', \DB::raw('COUNT(incapacidades.id) as total'))
                ->groupBy('padecimientos.padecimiento_nombre')
                ->get();
            $incapacidadesFiltradas = Incapacidad::whereRaw('LOWER(incapacidades.subarea) LIKE ?', ['%' . strtolower($area) . '%'])
                ->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_Inicio', [$fechaInicio, $fechaFin])
                        ->orWhereBetween('fecha_Fin', [$fechaInicio, $fechaFin]);
                })
                ->get();
        } else {
            $datos = Padecimiento::leftJoin('incapacidades', function ($join) use ($fechaInicio, $fechaFin) {
                $join->on('padecimientos.id', '=', 'incapacidades.padecimiento')
                    ->where(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->whereBetween('incapacidades.fecha_Inicio', [$fechaInicio, $fechaFin])
                            ->orWhereBetween('incapacidades.fecha_Fin', [$fechaInicio, $fechaFin]);
                    });
            })
                ->select('padecimientos.padecimiento_nombre', \DB::raw('COUNT(incapacidades.id) as total'))
                ->groupBy('padecimientos.padecimiento_nombre')
                ->get();
            $incapacidadesFiltradas = Incapacidad::where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_Inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_Fin', [$fechaInicio, $fechaFin]);
            })
                ->get();
        }
        $numeroIncapacidades = $incapacidadesFiltradas->count();
        $labels = $datos->pluck('padecimiento_nombre');
        $valores = $datos->pluck('total');
        return response()->json(['labels' => $labels, 'valores' => $valores, 'numeroIncapacidades' => $numeroIncapacidades]);
    }
    public function filtrarArea(Request $request)
    {
        $fechaInicio = $request->input('fecha_Inicio');
        $fechaFin = $request->input('fecha_Fin');
        $area = $request->input('area');
        $tipo = $request->input('tipo');
        $ramo = $request->input('ramo');
        $padecimiento = $request->input('padecimiento');
        $diasAutorizados = $request->input('dias_autorizados');

        $labels = [];
        $valores = [];

        if ($area != 0) {
            $area = Area::where('area_clave', $area)->first();
            $subareasIds = $area->subareas->pluck('subarea_clave')->toArray();

            $incapacidades = Incapacidad::whereIn('subarea', $subareasIds)
                ->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                        ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                })
                ->when($tipo != '0' && $tipo != 'Prolongada', function ($query) use ($tipo) {
                    return $query->where('tipo', $tipo);
                })
                ->when($tipo == 'Prolongada', function ($query) {
                    return $query->where('dias_acumulados', '>=', 30);
                })
                ->when($ramo != '0', function ($query) use ($ramo) {
                    return $query->where('ramo_de_seguro', $ramo);
                    return $query->where('ramo_de_seguro', $ramo);
                })
                ->when($padecimiento != '0', function ($query) use ($padecimiento) {
                    return $query->where('padecimiento', $padecimiento);
                })
                ->when($diasAutorizados != '0', function ($query) use ($diasAutorizados) {
                    if ($diasAutorizados == '4') {
                        return $query->where('dias_autorizados', '>', 3);
                    } else {
                        return $query->where('dias_autorizados', $diasAutorizados);
                    }
                })                
                ->get();

            foreach ($area->subareas as $subarea) {
                $count = $incapacidades->where('subarea', $subarea->subarea_clave)->count();
                $labels[] = $subarea->subarea_nombre;
                $valores[] = $count;
            }
            $numeroIncapacidades = $incapacidades->count();
        }else{
            $incapacidades = Incapacidad::where(function($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                        ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
                })
                ->when($tipo != '0' && $tipo != 'Prolongada', function ($query) use ($tipo) {
                    return $query->where('tipo', $tipo);
                })
                ->when($tipo == 'Prolongada', function ($query) {
                    return $query->where('dias_acumulados', '>=', 30);
                })
                ->when($ramo != '0', function ($query) use ($ramo) {
                        return $query->where('ramo_de_seguro', $ramo);
                })
                ->when($padecimiento != '0', function ($query) use ($padecimiento) {
                    return $query->where('padecimiento', $padecimiento);
                })
                ->when($diasAutorizados != '0', function ($query) use ($diasAutorizados) {
                    if ($diasAutorizados == '4') {
                        return $query->where('dias_autorizados', '>', 3);
                    } else {
                        return $query->where('dias_autorizados', $diasAutorizados);
                    }
                })                
                ->get();
            $areas = Area::with('subareas')->where('division_id', 'DX')->get();

            foreach ($areas as $area) {
                $count = 0;
                foreach ($area->subareas as $subarea) {
                    $count += $incapacidades->where('subarea', $subarea->subarea_clave)->count();
                }
                $labels[] = $area->area_nombre;
                $valores[] = $count;
            }
            $numeroIncapacidades = $incapacidades->count();
        }

        return response()->json(['labels' => $labels, 'valores' => $valores, 'numeroIncapacidades' => $numeroIncapacidades]);
    }
}
