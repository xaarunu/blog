<?php

namespace App\Http\Controllers;

use App\Models\ArchivoGeneral;
use App\Models\Area;
use App\Models\Audiometria;
use App\Models\Datosuser;
use App\Models\Division;
use App\Models\FileType;
use App\Models\UbicacionesArchivo;
use App\Models\ResultadoAudiometria;
use App\Models\Subarea;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AudiometriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:audiometria.index')->only('index', 'historicoUsuario');
        $this->middleware('can:audiometria.create')->only('create', 'store');
        $this->middleware('can:audiometria.edit')->only('edit', 'update', 'show');
        $this->middleware('can:audiometria.delete')->only('destroy');
    }

    public function index()
    {
        $divisiones = Division::all();
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas = Auth::user()->datos->getArea->subareas;

        $diagnosticos = ResultadoAudiometria::all();

        $audiometrias = Audiometria::whereHas('user', function($query){
            $query->where('subarea', Auth::user()->datos->getSubarea->subarea_clave);
            })->get();

        return view('audiometrias.index', compact('divisiones', 'areas', 'subareas', 'audiometrias', 'diagnosticos'));
    }

    public function historicoUsuario($rpe)
    {
        $usuario = Datosuser::where('rpe', $rpe)->firstOrFail();
        $registros = Audiometria::where('rpe', $rpe)->get();

        return view('audiometrias.historicoUsuario', compact('usuario', 'registros'));
    }

    public function create(Request $request)
    {
        $datosuser = Datosuser::where('rpe', $request->rpe)->first();
        $nombreCompleto = $datosuser ? implode(' ', $datosuser->only(['nombre', 'paterno', 'materno'])) : ' ';

        $resultados = ResultadoAudiometria::all();

        return view('audiometrias.crear', compact('datosuser', 'nombreCompleto', 'resultados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rpe' => 'required',
            'oido_izquierdo' => 'required|integer',
            'oido_derecho' => 'required|integer',
            'fecha_toma' => 'required|date|before_or_equal:today',
            'archivo' => 'required|file|mimes:pdf,doc,docx'
        ]);

        if ($request->has('archivo')) {
            $archivo = $request->archivo;

            // Obtener donde guardar archivo
            $carpeta = UbicacionesArchivo::where('categoria', 'audiometrias')->first();

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
            $registroArchivo = ArchivoGeneral::create([
                'id_ruta' => $carpeta->id,
                'hash' => $hash,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'tipo_archivo' => $extension->id,
            ]);
        }

        Audiometria::create([
            'rpe' => strtoupper($request->rpe),
            'fecha_toma' => $request->fecha_toma,
            'oido_izquierdo' => $request->oido_izquierdo,
            'oido_derecho' => $request->oido_derecho,
            'archivo' => $registroArchivo->id,
        ]);

        return redirect()->route('audiometrias.index');
    }

    public function edit($id)
    {
        $audiometria = Audiometria::where('id', $id)->with('user')->firstOrFail();
        $usuario = $audiometria->user;
        $nombre = $usuario ? implode(' ', $usuario->only(['nombre', 'paterno', 'materno'])) : '';
        $archivoRelacionado = $audiometria->file;
        $archivoRelacionado['filePath'] = $archivoRelacionado->pathDir->carpeta . $archivoRelacionado->hash . $archivoRelacionado->extension->extension;

        $resultados = ResultadoAudiometria::all();

        return view('audiometrias.editar', ['audiometria'=> $audiometria, 'nombreCompleto' => $nombre, 'resultados' => $resultados, 'archivo' => $archivoRelacionado]);
    }

    public function update(Request $request, $id)
    {
        $audiometriaOriginal = Audiometria::FindOrFail($id);

        $request->validate([
            'rpe' => 'required',
            'oido_izquierdo' => 'required|integer',
            'oido_derecho' => 'required|integer',
            'fecha_toma' => 'required|date|before_or_equal:today',
            'archivo' => 'file|mimes:pdf,doc,docx'
        ]);

        $request['rpe'] = strtoupper($request->rpe);

        if ($request->has('archivo')) {
            // Obtener información del archivo original para sobreescribirlo
            $archivoOriginal = Audiometria::where('id', $id)->with('file')->first()->file;
            $hash = $archivoOriginal->hash;
            $extension = $archivoOriginal->extension->extension;

            // Cambiar información en el registro del archivo vinculado
            $nuevoArchivo = $request->archivo;
            $archivoOriginal->fill(['nombre_archivo' => $nuevoArchivo->getClientOriginalName()]);
            $archivoOriginal->save();

            // Sobreescribir sobre el archivo original
            Storage::disk('public')->putFileAs('audiometrias', $nuevoArchivo, $hash.$extension);
        }

        $audiometriaOriginal->fill($request->except(['archivo']));
        $audiometriaOriginal->save();

        if(isset($request->origen)){
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }
        else{
            return redirect()->route('audiometrias.edit', $audiometriaOriginal->id)->with('message', 'Se actualizo la información correctamente!');
        }
    }

    public function destroy(Request $request, $id)
    {
        $audiometria = Audiometria::findOrFail($id);
        $archivoRelacionado = $audiometria->file;

        // Eliminar registro de audiometría
        if($audiometria->delete()) {
            // Eliminar archivo relacionado
            if(file_exists($archivoRelacionado->getFilePath())) {
                File::delete($archivoRelacionado->getFilePath());
            }

            $archivoRelacionado->delete();

            // Mensaje de eliminación correcto (API)
            if(isset($request->origen)){
                return response()->json([
                        'success' => true,
                    ]);
            }

            // Mensajes flash para mostrar en index/historico
            session()->flash('message', 'Audiometría eliminada correctamente!');
            session()->flash('message_type', 'success');
        } else {
            session()->flash('message', 'Hubo un error al intentar eliminar la audiometría!. Inténtalo más tarde...');
            session()->flash('message_type', 'danger');
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $datosuser = Datosuser::where('rpe', $request->rpe)->first();
        $datosuser->nombreCompleto = implode(' ', $datosuser->only(['nombre', 'paterno', 'materno']));

        return response()->json([
            'datosuser' => $datosuser
        ]);
    }

    public function filtrarAudiometrias(Request $request)
    {
        $division = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;

        $audiometrias = Audiometria::query()
            ->with('user')
            ->when($division != '0', function ($query) use ($division) {
                return $query->whereHas('user', function ($query) use ($division) {
                    $query->where('division', $division);
                });
            })
            ->when($area != '0', function ($query) use ($area) {
                return $query->whereHas('user', function ($query) use ($area) {
                    $query->where('area', $area);
                });
            })
            ->when($subarea != '0', function ($query) use ($subarea) {
                return $query->whereHas('user', function ($query) use ($subarea) {
                    $query->where('subarea', $subarea);
                });
            })
            ->get();

        /* $pruebas = Audiometria::with('user')->whereHas('user', function ($query) use ($division) {
            $query->where('division', '=', $division);
        })->when($subarea != '0', function ($q) use ($subarea) {
            return $q->whereHas('user', function ($query) use ($subarea) {
                $query->where('subarea', '=', $subarea);
            });
        })
            ->get(); */

        $diagnosticos = ResultadoAudiometria::all();

        return response()->json([
            'audiometrias' => $audiometrias,
            'diagnosticos' => $diagnosticos,
            'success' => true
        ]);
    }

    public function estadisticas(Request $request) {
        // Datos de filtrado
        // Datos de filtrado
        $divisionInicial = $request->division ?? Auth::user()->datos->getDivision->division_clave;
        $area = $request->area ?? Auth::user()->datos->area;
        $subarea = $request->subarea ?? 'all';

        // En caso de que se quiera filtrar: Evaluar si el usuario tiene acceso a esas áreas
        if($request->all()) {
            $usuarioLogueado = Auth::user();
            $error = false;

            // Si no se tiene rol "Admin" o "Doctora": Evaluar que no se acceda a otra división
            if(!$usuarioLogueado->hasAnyRole(['admin', 'Doctora']) and $usuarioLogueado->datos->division != $divisionInicial) {
                $error = true;
            }

            // Si no se tiene control de la división: Evaluar que no se acceda a otra zona/área
            if($usuarioLogueado->cannot('controlDivisional') and $usuarioLogueado->datos->area != $area) {
                $error = true;
            }

            if($error)
                return abort(403);
        }

        // Datos para mostrar en el filtro
        $area = $request->area ?? Auth::user()->datos->area;
        $subarea = $request->subarea ?? 'all';

        // En caso de que se quiera filtrar: Evaluar si el usuario tiene acceso a esas áreas
        if($request->all()) {
            $usuarioLogueado = Auth::user();
            $error = false;

            // Si no se tiene rol "Admin" o "Doctora": Evaluar que no se acceda a otra división
            if(!$usuarioLogueado->hasAnyRole(['admin', 'Doctora']) and $usuarioLogueado->datos->division != $divisionInicial) {
                $error = true;
            }

            // Si no se tiene control de la división: Evaluar que no se acceda a otra zona/área
            if($usuarioLogueado->cannot('controlDivisional') and $usuarioLogueado->datos->area != $area) {
                $error = true;
            }

            if($error)
                return abort(403);
        }

        // Datos para mostrar en el filtro
        $divisiones = Division::all();
        $areas = Area::where('division_id', $divisionInicial)->get();
        $subareas = Subarea::where('area_id', $area)->get();
        $tiposResultados = ResultadoAudiometria::where('diagnostico', '!=', 'AUDICION NORMAL')->get();


        $usuarios = DatosUser::whereHas('user', function ($query) use ($divisionInicial) {
                $query->where('division', $divisionInicial);
            })->when($area != 'all', function ($query) use ($area) {
                return $query->whereHas('user', function ($query) use ($area) {
                    $query->where('area', $area);
                });
            })->when($subarea != 'all', function ($query) use ($subarea) {
                return $query->whereHas('user', function ($query) use ($subarea) {
                    $query->where('subarea', $subarea);
                });
            })->get();

        $usuariosTotales = $usuarios->count();

        $audiometrias = Audiometria::query()
        ->with('user')
        ->whereHas('user', function ($query) use ($divisionInicial) {
            $query->where('division', $divisionInicial);
        })
        ->when($area != 'all', function ($query) use ($area) {
            return $query->whereHas('user', function ($query) use ($area) {
                $query->where('area', $area);
            });
        })
        ->when($subarea != 'all', function ($query) use ($subarea) {
            return $query->whereHas('user', function ($query) use ($subarea) {
                $query->where('subarea', $subarea);
            });
        })
        ->where(function ($query) {
            $query->where('oido_izquierdo', '!=', 1)
                ->orWhere('oido_derecho', '!=', 1);
        })
        ->get();



            foreach($audiometrias as $audiometria) {
                $divisionNombre = Division::where('division_clave', $audiometria->user->division)->pluck('division_nombre')->first();
                $audiometria->setAttribute('division_nombre', $divisionNombre);

                $areaNombre = Area::where('area_clave', $audiometria->user->area)->pluck('area_nombre')->first();
                $audiometria->setAttribute('area_nombre', $areaNombre);

                $subareaNombre = Subarea::where('subarea_clave', $audiometria->user->subarea)->pluck('subarea_nombre')->first();
                $audiometria->setAttribute('subarea_nombre', $subareaNombre);
            }

        // Agrupar y contar los datos según el resultado en cada oido
        $resultadosIzquierdo = $audiometrias->groupBy('oido_izquierdo')->map(function ($group) { return $group->count(); });
        $resultadosDerecho = $audiometrias->groupBy('oido_derecho')->map(function ($group) { return $group->count(); });


        $tiposResultados->map(function ($resultado) use ($resultadosIzquierdo, $resultadosDerecho) {
            if(!$resultadosIzquierdo->has($resultado->id)) {
                $resultadosIzquierdo[$resultado->id] = 0;
            }

            if(!$resultadosDerecho->has($resultado->id)) {
                $resultadosDerecho[$resultado->id] = 0;
            }
        });

        return view('audiometrias.estadisticas', [
            'divisiones' => $divisiones,
            'selectedDivision' => $divisionInicial,
            'areas' => $areas,
            'subareas' => $subareas,
            'etiquetas' => $tiposResultados->pluck('diagnostico')->toArray(),
            'resultadosIzquierdo' => $resultadosIzquierdo,
            'resultadosDerecho' => $resultadosDerecho,
            'totalAudiometrias' => count($audiometrias),
            'usuarios' => $audiometrias,
            'usuariosTotales' => $usuariosTotales
        ]);
    }
}
