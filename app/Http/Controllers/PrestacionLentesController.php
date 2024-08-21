<?php

namespace App\Http\Controllers;

use App\Models\ArchivoGeneral;
use App\Models\Area;
use App\Models\Datosuser;
use App\Models\FileType;
use App\Models\PrestacionLentes;
use App\Models\Subarea;
use App\Models\UbicacionesArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PrestacionLentesController extends Controller
{
    public function __construct() {
        $this->middleware('can:prestacion.index')->only('index','show','filtrar', 'historicoUsuario');
        $this->middleware('can:prestacion.create')->only('create', 'store');
        $this->middleware('can:prestacion.edit')->only('edit', 'update');
        $this->middleware('can:prestacion.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Datos para el filtro
        $areas = Area::where('division_id', Auth::user()->datos->division)->get();
        $subareas = Subarea::where('area_id', Auth::user()->datos->area)->get();

        // Obtener todos los usuarios pertenecientes a la subárea del usuario solicitante
        $usuarios = Datosuser::where('subarea', Auth::user()->datos->subarea)->get();

        // Obtener la ultima fecha de prestación de lentes solicitada por cada usuario
        $usuarios->map(function ($registro) {
            $ultimaSolicitud = PrestacionLentes::latest('fecha_asignacion')->where('rpe', $registro->rpe)->first();
            $registro->lentes = $ultimaSolicitud;

            return $registro;
        });

        $usuariosOrdenados = $usuarios->sortByDesc(function($user) {
            return $user?->lentes?->fecha_asignacion;
        });

        return view('prestacion_lentes.index', compact('areas', 'subareas'), ['usuarios' => $usuariosOrdenados]);
    }

    public function historicoUsuario($rpe)
    {
        // Comprobar que exista un usuario con el rpe solicitado
        $usuario = Datosuser::where('rpe', $rpe)->firstOrFail();
        $registros = PrestacionLentes::where('rpe', $rpe)->get();

        return view('prestacion_lentes.historicoUsuario', compact('usuario', 'registros'));
    }

    public function filtrar(Request $request)
    {
        // Obtener los datos recibidos
        $division = Auth::user()->datos->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;

        // Obtener todos los usuarios pertenecientes a la división del solicitante
        $query = Datosuser::where('division', $division);

        // Verificar si el usuario seleccionó una área especifica
        if ($area !== 'all') {
            $query->where('area', $area);
            // Verificar si el usuario seleccionó una subárea especifica
            if ($subarea !== 'all') {
                $query->where('subarea', $subarea);
            }
        }

        // Si se mandan ambas fechas, encontrár valores entre ellas
        if($fechaInicial && $fechaFinal) {
            $query->whereHas('lentes', function($query) use ($fechaInicial, $fechaFinal){
                $query->whereBetween('fecha_asignacion', [$fechaInicial, $fechaFinal]);
            });
        } elseif($fechaInicial) {
            $query->whereHas('lentes', function($query) use ($fechaInicial){
                $query->where('fecha_asignacion', '>=', $fechaInicial);
            });
        } elseif($fechaFinal) {
            $query->whereHas('lentes', function($query) use ($fechaFinal){
                $query->where('fecha_asignacion', '<=', $fechaFinal);
            });
        }

        // Obtener usuarios de con las caracteristicas deseadas
        $usuarios = $query->get();

        // Obtener la ultima fecha de prestación de lentes solicitada y nombre completo por cada usuario
        $usuarios->map(function ($registro) {
            $registro->nombreCompleto = implode(' ', $registro->only(['nombre', 'paterno', 'materno']));
            $ultimaSolicitud = $registro->lentes()->latest('fecha_asignacion')->first();
            $registro->lentes = $ultimaSolicitud;

            return $registro;
        });

        $usuariosOrdenados = $usuarios->sortByDesc(function($user) {
            return $user?->lentes?->fecha_asignacion;
        })->values();

        return response()->json([
            'usuarios' => $usuariosOrdenados,
            'success' => true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $usuario = null;

        if($request->has('rpe')) {
            $usuario = Datosuser::where('rpe', $request->rpe)->firstOrFail();
        }
        
        return view('prestacion_lentes.create', compact('usuario'));
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
            'rpe' => 'required|exists:datosusers,rpe',
            'fecha_asignacion' => 'required|date|before_or_equal:today',
            'archivo' => 'file|mimes:pdf'
        ]);

        if ($request->has('archivo')) {
            $registroArchivo = $this->crearArchivo($request->archivo);

            $request['archivo_id'] = $registroArchivo?->id ?? null;
        }

        $request['rpe'] = strtoupper($request->rpe);
        if(PrestacionLentes::create($request->all())){
            session()->flash('message', 'Prestación registrada correctamente!');
            session()->flash('message_type', 'success');
        } else {
            session()->flash('message', 'Hubo un error al registrar la prestación. Intentalo de nuevo...');
            session()->flash('message_type', 'error');
        }

        return redirect()->route('lentes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registro = PrestacionLentes::findOrFail($id);
        $usuario = $registro->user;

        return view('prestacion_lentes.show', compact('registro', 'usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $registro = PrestacionLentes::findOrFail($id);
        $usuario = $registro->user;

        return view('prestacion_lentes.edit', compact('registro', 'usuario'));
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
        $prestacionOriginal = PrestacionLentes::findOrFail($id);

        $request->validate([
            'rpe' => 'required|exists:datosusers,rpe',
            'fecha_asignacion' => 'required|date|before_or_equal:today',
            'archivo' => 'file|mimes:pdf'
        ]);

        if ($request->has('archivo')) {
            $archivoOriginal = $prestacionOriginal->archivo;

            if($archivoOriginal) {
                $hash = $archivoOriginal->hash;
                $extension = $archivoOriginal->extension->extension;

                $nuevoArchivo = $request->archivo;
                Storage::disk('public')->putFileAs('prestaciones/lentes', $nuevoArchivo, $hash.$extension);

                $archivoOriginal->fill(['nombre_archivo' => $nuevoArchivo->getClientOriginalName()]);
                $archivoOriginal->save();
                $request['archivo_id'] = $archivoOriginal->id;
            } else {
                $registroArchivo = $this->crearArchivo($request->archivo);
                $request['archivo_id'] = $registroArchivo->id;
            }
        }

        $request['rpe'] = strtoupper($request->rpe);

        $prestacionOriginal->fill($request->all());

        if($prestacionOriginal->save()){
            session()->flash('message', 'Prestación actualizada correctamente!');
            session()->flash('message_type', 'success');
        } else {
            session()->flash('message', 'Hubo un error al actualizar la prestación. Intentalo de nuevo...');
            session()->flash('message_type', 'error');
        }

        return redirect()->route('lentes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registro = PrestacionLentes::findOrFail($id);
        $archivo = $registro->archivo;

        // Eliminar archivo relaciónado
        if($archivo) {
            if(file_exists($archivo->getFilePath())) {
                File::delete($archivo->getFilePath());
            }
            $archivo->delete();
        }

        if($registro->delete()) {
            session()->flash('message', 'Registro de prestación eliminado correctamente!');
            session()->flash('message_type', 'success');
        } else {
            session()->flash('message', 'Hubo un error al eliminar el registro.');
            session()->flash('message_type', 'error');
        }

        return redirect()->back();
    }

    private function crearArchivo($archivo) {
        // Obtener donde guardar archivo
        $carpeta = UbicacionesArchivo::where('categoria', 'lentes')->first();

        // Si no existe el registro de la categoria de archivo
        if(!$carpeta) {
            $carpeta = UbicacionesArchivo::create(['categoria'=> 'lentes', 'carpeta' => 'storage/prestaciones/lentes/']);
        }

        // Obtener extensión del archivo
        $extension = FileType::where('extension', '.' . $archivo->getClientOriginalExtension())->first();

        // Si no existe la extensión en la BD
        if(!$extension) {
            $extension = FileType::create(['extension'=> ('.' . $archivo->getClientOriginalExtension())]);
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
}
