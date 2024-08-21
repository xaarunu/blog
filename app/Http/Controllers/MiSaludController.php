<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Datosuser;
use App\Models\MiSalud;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\enfermedades_cronicas;
use App\Models\Personales;
use App\Models\User;
use App\Models\usuario_enfermedad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MiSaludController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:notaMedica.index')->only('index', 'indice', 'show', 'archivos', 'showAllNotasMedicas');
        $this->middleware('can:notaMedica.create')->only('create', 'store');
        $this->middleware('can:notaMedica.edit')->only('edit', 'update');
        $this->middleware('can:notaMedica.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $datos = Datosuser::where('rpe',Auth::user()->rpe)->firstOrFail();
        $datosuser = DB::table('datosusers')->get(); 
        $miSalud = MiSalud::all();

        return view('salud.index', compact('miSalud'), ['datos'=>$datos, 'datosusers'=>$datosuser]);

    }

    public function indice($R)
    {
        $datos = Datosuser::where('rpe',Auth::user()->rpe)->firstOrFail();
        $datosuser = Datosuser::where('rpe',$R)->firstOrFail();
        $miSalud = MiSalud::whereIn('rpe', Personales::where('rpe', $R)->pluck('rpe'))->get();

        return view('salud.index', compact('miSalud'), ['datos'=>$datos, 'datosusers'=>$datosuser]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $datosuser = Datosuser::where('rpe',$request->rpe)->first();
        $datosuser->nombreCompleto = $datosuser->nombre . " " . $datosuser->paterno . " " . $datosuser->materno;
        $antecedente = Personales::where('rpe',  $request->rpe)->first();
        $tiene_antecedente=true;
        if (!$antecedente) {
            $tiene_antecedente=false;
        }
        $expedienteUsuario = User::where('rpe', $request->rpe)->with('enfermedadesCronicas.enfermedadCronica')->with('datos')->with(['salud' => function ($query) {
            $query->latest();
        }])->first();
        
        $datosAnteriores = isset($expedienteUsuario->salud[0]) ? $expedienteUsuario->salud[0] : null;
        $enfermedades = enfermedades_cronicas::all();
        $enfermedadesDetectadas = $expedienteUsuario->enfermedadesCronicas;

        $enfermedadesArreglos = [];

        foreach ($enfermedades as $enfermedad) {
            $enfermedadesArreglos[$enfermedad->nombre] = [
                'nombre' => $enfermedad->nombre,
                'id' => $enfermedad->id,
                'activado' => false,
            ];
        }

        foreach ($enfermedadesDetectadas as $enfermedadDetectada) {
            $enfermedadNombre = $enfermedadDetectada->enfermedadCronica->nombre;
            if (isset($enfermedadesArreglos[$enfermedadNombre])) {
                $enfermedadesArreglos[$enfermedadNombre]['activado'] = true;
            }
        }
        
        return response()->json([
            'datosuser' => $datosuser,
            'expedienteUsuario' => $expedienteUsuario,
            'datosAnteriores' => $datosAnteriores,
            'enfermedadesArreglos' => $enfermedadesArreglos,
            'tiene_antecedente' => $tiene_antecedente,
            'antecedente'=> $antecedente,
        ]);
    }
    public function create(Request $request)
    { 
        $datos = Datosuser::where('rpe',$request->rpe)->first();
        $nombre= $datos? ($datos->nombre . " " . $datos->paterno . " " . $datos->materno) : "";
        $antecedente = Personales::where('rpe',  $request->rpe)->first();
        $tiene_antecedente=true;
        if (!$antecedente && $request->rpe != 0) {
            // Si no hay antecedente, envía un mensaje y redirige a la creación de antecedente
            $tiene_antecedente =false;
            $datos = Datosuser::where('rpe',Auth::user()->rpe)->firstOrFail();
            $datosuser = Datosuser::where('rpe', $request->rpe)->firstOrFail();

            return view('salud.index', ['datos'=>$datos, 'datosusers'=>$datosuser, 'tiene_antecedente'=>$tiene_antecedente, 'miSalud' => []]);
        }
        $expedienteUsuario = User::where('rpe', $request->rpe)->with('enfermedadesCronicas.enfermedadCronica')->with('datos')->with(['salud' => function ($query) {
            $query->latest();
        }])->first();
        $datosAnteriores = isset($expedienteUsuario->salud[0]) ? $expedienteUsuario->salud[0] : null;
        $enfermedades = enfermedades_cronicas::all();
        $enfermedadesDetectadas = $expedienteUsuario ? $expedienteUsuario->enfermedadesCronicas : null;
        $enfermedadesArreglos = [];

        foreach ($enfermedades as $enfermedad) {
            $enfermedadesArreglos[$enfermedad->nombre] = [
                'nombre' => $enfermedad->nombre,
                'id' => $enfermedad->id,
                'activado' => false,
            ];
        }
        if($enfermedadesDetectadas){
            foreach ($enfermedadesDetectadas as $enfermedadDetectada) {
                $enfermedadNombre = $enfermedadDetectada->enfermedadCronica->nombre;
                if (isset($enfermedadesArreglos[$enfermedadNombre])) {
                    $enfermedadesArreglos[$enfermedadNombre]['activado'] = true;
                }
            }
        }

        return view('salud.crear', ['datosuser'=>$expedienteUsuario,'datos'=>$datos, 
                                    'datosAnteriores'=>$datosAnteriores, 'enfermedades'=>$enfermedadesArreglos, 'nombre'=>$nombre,'antecedente'=> $antecedente]);
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
            'rpe' => 'required|exists:users,rpe',
            'fecha_nacimiento' => 'required|date|date_format:Y-m-d|before_or_equal:'.now()->subYears(18)->toDateString(),
            'sexo' => 'required',
            'fecha' => 'required|date|date_equals:today',
            'hora' => 'required',
            'altura' => 'required',
            'peso' => 'required',
            'imc' => 'required',
            'cintura' => 'required',
            'cadera' => 'required',
            'presionSis' => 'required',
            'temperatura' => 'required',
            'saturacion' => 'required',
            'glucosa' => 'required|numeric',
            'cardiaca' => 'required',
            'respiratoria' => 'required',
            'alergias' => 'required',
            'tipo' => 'required',
            'observaciones' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',
        ]);
        $request['rpe'] = strtoupper($request->rpe);
        $ms = $request->input();
        $ms['hora_fin'] = date('H:i');

        $salud = MiSalud::create($ms);
        
        if($request->has('archivo'))
        {
            foreach($request->file('archivo') as $archivo){
                $hash = Str::random(5);
                $rutaSave = '/archivos/miSalud/';
                $pdf = $hash . '-' . $archivo->getClientOriginalName();
                $archivo->move(public_path() . $rutaSave, $pdf);
                
                Archivo::create([
                    'nombre' =>$archivo->getClientOriginalName(),
                    'archivo' => $rutaSave . $pdf,
                    'mi_salud_id' => $salud->id
                ]);
            }
        }
        // Obtén la lista de IDs de enfermedades seleccionadas en el formulario
        $selectedEnfermedadesIds = array_keys($request->except(['_token', 'rpe','nombrefalse','presionDia','Alimentos','Medicamentos','Ninguna','Animales', 'fecha_nacimiento', 'sexo', 'fecha', 'hora', 'altura', 'peso', 'imc', 'cintura', 'cadera', 'presionSis', 'temperatura', 'saturacion', 'glucosa', 'cardiaca', 'respiratoria', 'alergias', 'tipo', 'observaciones', 'diagnostico', 'tratamiento','archivo']));
        // Elimina cualquier enfermedad que el usuario tenía pero ya no está seleccionada
        usuario_enfermedad::where('rpe', $request->rpe)
        ->whereNotIn('enfermedades_cronicas_id', $selectedEnfermedadesIds)
        ->delete();

        // Recorrer las enfermedades seleccionadas
        foreach ($selectedEnfermedadesIds as $enfermedadId) {

            // Buscar si existe un registro para la enfermedad
            $usuarioEnfermedad = usuario_enfermedad::where('rpe', $request->rpe)
                ->where('enfermedades_cronicas_id', $enfermedadId)
                ->first();

            // Actualizar la fecha de detección si el registro existe
            if ($usuarioEnfermedad) {
                if ($request->fecha < $usuarioEnfermedad->fecha_detectada) {
                    $usuarioEnfermedad->fecha_detectada = $request->fecha;
                    $usuarioEnfermedad->save();
                }
            } else {
                // Crear un nuevo registro
                usuario_enfermedad::create([
                    'enfermedades_cronicas_id' => $enfermedadId,
                    'rpe' => $request->rpe,
                    'fecha_detectada' => $request->fecha,
                ]);
            }
        }
        
        return redirect()->route('saluds.indice', $request->rpe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MiSalud  $miSalud
     * @return \Illuminate\Http\Response
     */

    public function show(MiSalud  $miSalud)
    {
        //$miSalud = MiSalud::paginate(5);
        //return view('salud.show', compact('miSalud'));

        return view('salud.show', compact('miSalud'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MiSalud  $miSalud
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $miSalud = MiSalud::where('id',$id)->firstOrFail();
        $archivo = Archivo::where('mi_salud_id', $id)->get();

        $datos = $this->enfermedadesArreglo($miSalud->rpe);
        return view('salud.editar', compact('datos','miSalud','archivo'));
    }

    public function enfermedadesArreglo($rpe)
    {
        $datos = User::where('rpe', $rpe)->select('rpe')->with('enfermedadesCronicas.enfermedadCronica')->first();

        $arreglo = [];
        if(isset($datos->enfermedadesCronicas)){
            foreach($datos->enfermedadesCronicas as $enfermedades){
                $arreglo[$enfermedades->enfermedadCronica->id] = $enfermedades->enfermedadCronica->nombre;
            }
        }
        
        return $arreglo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MiSalud  $miSalud
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $miSalud = MiSalud::FindOrFail($id);
        $request['rpe'] = strtoupper($request->rpe);
        $rpe = $miSalud['rpe'];

        $request->validate([
            'rpe' => 'required|exists:users,rpe',
            'altura' => 'required|numeric|min:1',
            'peso' => 'required|numeric|min:1',
            'imc' => 'required|numeric|min:1',
            'cintura' => 'required|numeric|min:1',
            'cadera' => 'required|numeric|min:1',
            'presionSis' => 'required|numeric|min:1',
            'temperatura' => 'required|numeric|min:1',
            'saturacion' => 'required|numeric',
            'glucosa' => 'required|numeric',
            'cardiaca' => 'required|numeric',
            'respiratoria' => 'required|numeric',
            'alergias' => 'required',
            'tipo' => 'required',
            'observaciones' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',
            ]);

        $miSalud->fill($request->all());
        $miSalud->save();
        
        if(isset($request->origen)){
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }
        else{
            return redirect()->route('saluds.indice',$rpe)->with('success', 'Expediente actualizado con éxito'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MiSalud  $miSalud
     * @return \Illuminate\Http\Response
     */

    public function destroy(MiSalud $miSalud, $id)
    {
        $miSalud = MiSalud::findOrFail($id);
        $rpe = $miSalud['rpe'];
        $archivo = Archivo::where('mi_salud_id', $id)->get();

        foreach($archivo as $archi)
        {
            if(file_exists(public_path($archi->archivo)))
            {
                unlink(public_path($archi->archivo));
            }
        }
    
        $miSalud->delete();
        return redirect()->route('saluds.indice',$rpe)->with('success', 'Expediente eliminada con éxito'); 
    }

    public function inicio() 
    {
        $vc = DB::table('view_counter')->where('pagina', 'bienestar')->first()->visitas + 1; 
        DB::table('view_counter')->where('pagina', 'bienestar')->update(['visitas'=>$vc]);
        return view('salud.inicio');
    }

    public function archivos(Request $request){

        $idSalud = MiSalud::where('rpe', $request->rpe)->with("archivos")->get();
        $usuario = DatosUser::where('rpe', $request->rpe)->firstOrFail();

        return view('salud.archivos',compact('idSalud', 'usuario'));
    }
    public function showAllNotasMedicas(){
        $antecedentesActivos = Personales::all()->pluck('rpe');
        $miSalud = MiSalud::whereIn('rpe', $antecedentesActivos)
                            ->with('user','user.getArea','user.getSubarea')
                            ->whereHas('user', function($query) {
                                $query->where('area', Auth::user()->datos->area);
                            })
                            ->get();
        $divisiones = Division::all();
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        return view('salud.show-all-notas',[
            'miSalud'=>$miSalud,
            'divisiones' => $divisiones,
            'areas' => $areas,
            'subareas' => $subareas,
        ]);
    }

    public function filtroShow_allNotas(Request $request){
        $area = $request->area;
        $subarea = $request->subarea;
        $fecha_inicio = date($request->input('fecha_inicio'));
        $fecha_fin = date($request->input('fecha_fin'));
      
        $query = Misalud::with(['user.getArea', 'user.getSubarea'])
            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        if ($area !== 'all') {
            $query->whereHas('user.getArea', function ($q) use ($area) {
                $q->where('area', $area);
            });

            if ($subarea !== 'all') {
                $query->whereHas('user.getSubarea', function ($q) use ($subarea) {
                    $q->where('subarea', $subarea);
                });
            }
        }
        $notasFiltradas = $query->get();

        return response()->json([
            'notas' => $notasFiltradas,
        ]);
    }
}

