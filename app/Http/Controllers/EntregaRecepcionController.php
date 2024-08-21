<?php

namespace App\Http\Controllers;

use App\Console\Commands\AsignerRolesTemporales;
use App\Models\ArchivoGeneral;
use App\Models\Area;
use App\Models\Division;
use App\Models\EntregaRecepcion;
use App\Models\FileType;
use App\Models\RolPrestado;
use App\Models\Subarea;
use App\Models\UbicacionesArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class EntregaRecepcionController extends Controller
{
    public function __construct() {
        $this->middleware('can:recepcion.index')->only('index','show','filtrar');
        $this->middleware('can:recepcion.create')->only('create', 'store');
        $this->middleware('can:recepcion.edit')->only('edit', 'update');
        $this->middleware('can:recepcion.delete')->only('destroy');
    }

    public function index() {
        $divisiones = Division::all();
        $areas = Area::where('division_id', Auth::user()->datos->division)->get();
        $subareas = Subarea::where('area_id', Auth::user()->datos->area)->get();

        $entregasRecepcion = EntregaRecepcion::with('usuarioAusente')
            ->whereHas('usuarioAusente', function ($query) {
                $query->where('division', Auth::user()->datos->division);
                $query->where('area', Auth::user()->datos->area);
            })->get();

        return view('recepcion.index', compact('divisiones', 'areas', 'subareas'), ['registros'=> $entregasRecepcion]);
    }

    public function show($id) {
        $entrega = EntregaRecepcion::findOrFail($id);

        return view('recepcion.show', compact('entrega'));
    }

    public function create() {
        // Si no se tiene permiso "Control Divisional" solo debe tener acceso a dar sus propios roles
        $userAusente = (!Auth::user()->can('controlDivisional')) ? Auth::user() : null;
        $infoRoles = Role::select('id', 'name')->get();

        return view('recepcion.crear', ['infoRoles' => $infoRoles, 'usuarioAusente' => $userAusente]);
    }

    public function store(Request $request) {
        $validaciones = [
            'rpe_ausente' => 'required|exists:datosusers,rpe|different:rpe_receptor',
            'rpe_receptor' => 'required|exists:datosusers,rpe',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_final' => 'required|date|after:fecha_inicio',
            'motivo' => 'required|min:2',
            'roles' => 'required|array',
            'archivo' => 'file|mimes:pdf'
        ];

        // Agregar validación en caso de no contar con permiso de *Control Divisional*
        if(!Auth::user()->can('controlDivisional')) {
            $validaciones['rpe_ausente'] .= '|in:' . Auth::user()->rpe;
            $mensajePersonalizado = [
                'rpe_ausente.in' => 'No tienes permiso para agendar entregas de recepción de otros usuarios!.'
            ];
        }
        $request->validate($validaciones, $mensajePersonalizado ?? []);

        if($request->has('archivo')) {
            $resultadoArchivo = $this->crearArchivo($request->archivo);
            $request['id_archivo'] = $resultadoArchivo?->id ?? null;
        }

        $request['rpe_ausente'] = strtoupper($request->rpe_ausente);
        $request['rpe_receptor'] = strtoupper($request->rpe_receptor);

        $registroRecepcion = EntregaRecepcion::create($request->except('roles'));

        // Registrar roles a "prestar"
        foreach ($request->roles as $rol) {
            RolPrestado::create([
                'id_entrega' => $registroRecepcion->id,
                'id_rol' => $rol
            ]);
        }

        // Si la fecha de inicio es el día actual, ejecutar los cambios de roles
        if($request->fecha_inicio == Date('Y-m-d')) {
            $comando = new AsignerRolesTemporales();
            $comando->nuevaAsignacion($registroRecepcion);
        }

        session()->flash('message_type', 'success');
        session()->flash('message', 'Se registro la entrega de recepción correctamente!');

        return redirect()->route('recepcion.index');
    }

    public function edit($id) {
        $registro = EntregaRecepcion::findOrFail($id);
        $user = Auth::user();

        // Evaluar que el registro a editar tenga el mismo rpe ausente que el del "solicitante"
        // en caso contrario, debe contar con el permiso "Control Divisional"
        if($registro->rpe_ausente == $user->rpe || $user->can('controlDivisional')) {
            $retorno = view('recepcion.edit', compact('registro'));
        } else {
            session()->flash('message', 'No se tiene acceso a la edición de ese registro!.');
            session()->flash('message_type', 'danger');

            $retorno = redirect()->route('recepcion.index');
        }
        
        return $retorno;
    }

    public function update(Request $request, $id) {
        $entregaRecepcionOriginal = EntregaRecepcion::findOrFail($id);

        $validaciones = [
            'rpe_ausente' => 'required|exists:datosusers,rpe|different:rpe_receptor',
            'rpe_receptor' => 'required|exists:datosusers,rpe',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after:fecha_inicio',
            'motivo' => 'required|min:2',
            'roles' => 'required|array',
            'archivo' => 'file|mimes:pdf'
        ];

        // Agregar validación en caso de no contar con permiso de *Control Divisional*
        if(!Auth::user()->can('controlDivisional')) {
            $validaciones['rpe_ausente'] .= '|in:' . Auth::user()->rpe;
            $mensajePersonalizado = [
                'rpe_ausente.in' => 'No tienes permiso para agendar entregas de recepción de otros usuarios!.'
            ];
        }
        $request->validate($validaciones, $mensajePersonalizado ?? []);

        if ($request->has('archivo')) {
            $archivoOriginal = $entregaRecepcionOriginal->file;

            if($archivoOriginal) {
                $hash = $archivoOriginal->hash;
                $extension = $archivoOriginal->extension->extension;

                $nuevoArchivo = $request->archivo;
                Storage::disk('public')->putFileAs('recepciones', $nuevoArchivo, $hash.$extension);

                $archivoOriginal->fill(['nombre_archivo' => $nuevoArchivo->getClientOriginalName()]);
                $archivoOriginal->save();
                $request['id_archivo'] = $archivoOriginal->id;
            } else {
                $registroArchivo = $this->crearArchivo($request->archivo);
                $request['id_archivo'] = $registroArchivo->id;
            }
        }

        // Actualizar roles a "prestar"
        $entregaRecepcionOriginal->rolesPrestados()->delete();
        foreach($request->roles as $rol) {
            RolPrestado::create([
                'id_entrega' => $entregaRecepcionOriginal->id,
                'id_rol' => $rol
            ]);
        }

        $request['rpe_ausente'] = strtoupper($request->rpe_ausente);
        $request['rpe_receptor'] = strtoupper($request->rpe_receptor);

        $entregaRecepcionOriginal->fill($request->all());
        $entregaRecepcionOriginal->save();

        // Si la nueva fecha de inicio es el día actual, ejecutar los cambios de roles
        if($request->fecha_inicio == Date('Y-m-d')) {
            $comando = new AsignerRolesTemporales();
            $comando->nuevaAsignacion($entregaRecepcionOriginal);
        }

        session()->flash('message', 'El registro se modifico correctamente!');
        session()->flash('message_type', 'success');

        return redirect()->route('recepcion.index');
    }

    public function destroy($id) {
        $registro = EntregaRecepcion::findOrFail($id);
        $user = Auth::user();

        // Evaluar que el registro a eliminar tenga el mismo rpe ausente que el del "solicitante"
        // en caso contrario, debe contar con el permiso "Control Divisional"
        if($registro->rpe_ausente == $user->rpe || $user->can('controlDivisional')) {
            $archivo = $registro->archivo;

            // Devolver roles correspondientes
            $comando = new AsignerRolesTemporales();
            $comando->entregaFinalizada($registro);
    
            // Eliminar archivo relaciónado
            if($archivo) {
                if(file_exists($archivo->getFilePath())) {
                    File::delete($archivo->getFilePath());
                }
                $archivo->delete();
            }
    
            if($registro->delete()) {
                session()->flash('message', 'Entrega eliminada correctamente!');
                session()->flash('message_type', 'success');
            } else $error = true;
        } else {
            $error = true;
        }

        if(isset($error)) {
            session()->flash('message', 'Ocurrio un error al eliminar el registro.');
            session()->flash('message_type', 'danger');
        }

        return redirect()->route('recepcion.index');
    }

    private function crearArchivo($archivo) {
        // Obtener donde guardar archivo
        $carpeta = UbicacionesArchivo::where('categoria', 'recepciones')->first();

        // Si no existe el registro de la categoria de archivo
        if(!$carpeta) {
            $carpeta = UbicacionesArchivo::create(['categoria'=> 'recepciones', 'carpeta' => 'storage/recepciones/']);
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

    public function filtrar(Request $request) {
        // Obtener los datos recibidos
        $division = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;

        // Obtener los datos del modelo
        $query = EntregaRecepcion::with([
                    'usuarioAusente',
                    'usuarioReceptor',
                    'rolesPrestados'])
            ->whereHas('usuarioAusente', function ($query) use ($division) {
                $query->where('division', $division);});

        if($fechaInicial) {
            $query->where('fecha_inicio', '>=', $fechaInicial);
        }

        if($fechaFinal) {
            $query->where('fecha_final', '<=', $fechaFinal);
        }

        // Verificar si el usuario seleccionó una área especifica
        if ($area !== 'all') {
            $query->whereHas('usuarioAusente', function ($query) use ($area, $subarea) {
                $query->where('area', $area);
                // Verificar si el usuario seleccionó una subárea especifica
                if ($subarea !== 'all') {
                    $query->where('subarea', $subarea);
                }
            });
        }

        $entregasRecepcion = $query->get();
        $infoRoles = Role::select('id', 'name')->get();

        return response()->json([
            'entregas' => $entregasRecepcion,
            'infoRoles' => $infoRoles,
            'success' => true,
        ]);
    }
}
