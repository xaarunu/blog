<?php

namespace App\Http\Controllers;
use DB;
use DataTables;
use App\Models\Area;
use App\Models\MiSalud;
use App\Models\Division;
use App\Models\ProSalud;
use App\Models\Datosuser;
use App\Models\Personales;
use App\Models\Audiometria;
use App\Models\Incapacidad;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Models\UsuarioUnidad;
use App\Models\UnidadesMedicas;
use App\Models\usuario_enfermedad;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\enfermedades_cronicas;
use Illuminate\Support\Facades\Storage;

class PersonalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:antecedente.index')->only('index', 'indice', 'show', 'showAllAntecedentes', 'show_allAntecedentes');
        $this->middleware('can:antecedente.create')->only('create', 'store', 'search');
        $this->middleware('can:antecedente.edit')->only('edit', 'update');
        $this->middleware('can:antecedente.delete')->only('destroy');
        $this->middleware('can:antecedente.stats')->only('estadisticaGeneral', 'filtrarPersonales');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$datos = Datosuser::where('rpe',Auth::user()->rpe)->firstOrFail();
        //$datosuser = DB::table('datosusers')->get();
        $antecedentes_personales = Personales::all();
        return view('personales.index', compact('antecedentes_personales'));
        //,['datos'=>$datos, 'datosusers'=>$datosuser]
    }

    public function indice($rpe)
    {
        $comprobacion = Datosuser::where('rpe', $rpe)->firstOrFail();      //Variable no se usa pero sirve para retornar 404 en caso no exista el rpe
        $antecedentes_personales = Personales::where('rpe', $rpe)->get();

        return view('personales.index', compact('antecedentes_personales'),['rpe' => $rpe]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $datouser = Datosuser::with('getArea', 'getSubarea', 'getDivision')->where('rpe', $request->rpe)->first();
        $datouser->nombreCompleto = $datouser->nombre . " " . $datouser->paterno . " " . $datouser->materno;
        $area = $datouser ? $datouser->getArea : null;
        $subarea = $datouser ? $datouser->getSubarea : null;
        $antecedente = Personales::where('rpe',  $request->rpe)->first();
        $tieneAntecedente = $antecedente ? true : false;

        return response()->json([
            'datouser' => $datouser,'areas' => $area, 'subareas' => $subarea,
            'tieneAntecedente' => $tieneAntecedente
        ]);
    }
    public function create($rpe)
    {
        $datouser = Datosuser::with('getArea', 'getSubarea', 'getDivision')->where('rpe', $rpe)->first();
        $nombre = $datouser ? implode(' ', $datouser->only(['nombre', 'paterno', 'materno'])) : '';
        $unidades = UnidadesMedicas::all();
        $area = $datouser ? $datouser->getArea : null;
        $subarea = $datouser ? $datouser->getSubarea : null;
        $enfermedades = enfermedades_cronicas::all();
        $enfermedadesArreglos = [];

        foreach ($enfermedades as $enfermedad) {
            $enfermedadesArreglos[$enfermedad->nombre] = [
                'nombre' => $enfermedad->nombre,
                'id' => $enfermedad->id,
                'activado' => false,
            ];
        }

        return view('personales.crear',[ 'rpe' => $rpe,
                                        'areaUser' => $area, 'subareaUser' => $subarea, 'datos' => $datouser,
                                        'unidades' => $unidades, 'nombre'=> $nombre,'enfermedades'=>$enfermedadesArreglos,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $rpe)
    {
        //dd($request);
        $request->validate([
            'rpe'=>'required|exists:users,rpe',
            'nss'=>'required|numeric|digits:11',
            'unidad_medica' => 'required|integer',
            'cirugia'=> 'required',
            'vacuna'=> 'required',
            'fecha_vacuna'=> 'required|date|before_or_equal:today',
            'inmunizaciones'=> 'required',
            'herencia'=> 'required',
            'area'=> 'required',
            'subarea'=> 'required',
            'tabaquismo'=> 'required',
            'alcholismo'=> 'required',
            'toxicomanias'=> 'required',
            'turno' => 'required',
            'consultorio' => 'required|integer',
            'fecha_nacimiento' => 'required|date|date_format:Y-m-d|before_or_equal:'.now()->subYears(18)->toDateString(),
            'sexo' => 'required',
            'altura' => 'required',
            'peso' => 'required',
            'imc' => 'required',
            'cintura' => 'required',
            'cadera' => 'required',
            'presionSis' => 'required',
            'glucosa' => 'required',
            'alergias' => 'required',
            'tipo' => 'required',
            'observaciones' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',

        ]);
        $request['rpe'] = strtoupper($request->rpe);
        $area = $request->input('area');
        $subarea = $request->input('subarea');
        $ap = $request->except(['areas_nombre', 'subareas_nombre']);
        $registro = Personales::create($ap);
        $exists = UsuarioUnidad::where("rpe", $request['rpe'])->first();
        if($exists){
            $exists->unidad = $request['unidad_medica'];
            $exists->save();
        }
        else{
            UsuarioUnidad::firstOrCreate(['rpe' => $request['rpe'], 'unidad' => $request['unidad_medica'],'consultorio' => $request['consultorio'], 'turno' => $request['turno']]);
        }

        // Obtén la lista de IDs de enfermedades seleccionadas en el formulario
        $selectedEnfermedadesIds = array_keys($request->except(['_token', 'rpe','nombrefalse','presionDia','Alimentos','Medicamentos','Ninguna','Animales', 'fecha_nacimiento', 'sexo', 'fecha_vacuna', 'hora', 'altura', 'peso', 'imc', 'cintura', 'cadera', 'presionSis', 'temperatura', 'saturacion', 'glucosa', 'cardiaca', 'respiratoria', 'alergias', 'tipo', 'observaciones', 'diagnostico', 'tratamiento','area','subarea','nss','unidad_medica','consultorio','turno','vacuna','inmunizaciones','cirugia','herencia','tabaquismo','alcholismo','toxicomanias','areas_nombre','subareas_nombre']));
        // Recorrer las enfermedades seleccionadas
        foreach ($selectedEnfermedadesIds as $enfermedadId) {
            // Crear un nuevo registro
            usuario_enfermedad::create([
                'enfermedades_cronicas_id' => $enfermedadId,
                'rpe' => $request->rpe,
                'fecha_detectada' => $registro->created_at->format('Y-m-d'),
            ]);

        }

        return redirect()->route('personales.indice', $request->rpe);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($antecedentes_personales)
    {
        // Datos generales
        $unidades = UnidadesMedicas::all();
        $enfermedades = enfermedades_cronicas::all();

        // Datos del usuario
        $antecedentes_personales = Personales::where('rpe',$antecedentes_personales)->firstOrFail();
        $datosuserAntecedentes = Datosuser::where('rpe', $antecedentes_personales->rpe)->firstOrFail();
        $unidadMedica = UsuarioUnidad::where('rpe', $antecedentes_personales->rpe)->first();
        $enfermedadesUsuario = usuario_enfermedad::where('rpe', $antecedentes_personales->rpe)->pluck('enfermedades_cronicas_id')->toArray();
        $nombre = implode(' ', $datosuserAntecedentes->only(['nombre', 'paterno', 'materno']));

        $enfermedadesArreglos = [];
        foreach ($enfermedades as $enfermedad) {
            $enfermedadesArreglos[$enfermedad->nombre] = [
                'nombre' => $enfermedad->nombre,
                'id' => $enfermedad->id,
                'activado' => in_array($enfermedad->id, $enfermedadesUsuario),
            ];
        }

        return view('personales.editar', ['usuario' => $datosuserAntecedentes, 'enfermedades' => $enfermedadesArreglos],
        compact('antecedentes_personales', 'nombre', 'unidades', 'unidadMedica'));
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
        $request->validate([
            'rpe'=>'required|exists:users,rpe',
            'nss'=>'required|numeric|digits:11',
            'unidad_medica' => 'required|integer',
            'cirugia'=> 'required',
            'vacuna'=> 'required',
            'fecha_vacuna'=> 'required|date|before_or_equal:today',
            'inmunizaciones'=> 'required',
            'herencia'=> 'required',
            'tabaquismo'=> 'required',
            'alcholismo'=> 'required',
            'toxicomanias'=> 'required',
            'turno' => 'required',
            'consultorio' => 'required|integer',
            'fecha_nacimiento' => 'required|date|date_format:Y-m-d|before_or_equal:'.now()->subYears(18)->toDateString(),
            'sexo' => 'required',
            'altura' => 'required',
            'peso' => 'required',
            'imc' => 'required',
            'cintura' => 'required',
            'cadera' => 'required',
            'presionSis' => 'required',
            'glucosa' => 'required',
            'alergias' => 'required',
            'tipo' => 'required',
            'observaciones' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',
            ]);

        $request['rpe'] = strtoupper($request->rpe);
        $ant_per = Personales::FindOrFail($id);
        $ant_per->fill($request->all());
        $ant_per->save();

        $registroUnidad = UsuarioUnidad::FindOrFail($request->rpe);
        $registroUnidad->fill([
            'unidad' => $request->unidad_medica,
            'consultorio' => $request->consultorio,
            'turno' => $request->turno,
        ]);
        $registroUnidad->save();

        // Obtén la lista de IDs de enfermedades seleccionadas en el formulario
        $selectedEnfermedadesIds = array_keys($request->except(['_method', '_token', 'rpe','nombrefalse','presionDia','Alimentos','Medicamentos','Ninguna','Animales', 'fecha_nacimiento', 'sexo', 'fecha_vacuna', 'hora', 'altura', 'peso', 'imc', 'cintura', 'cadera', 'presionSis', 'temperatura', 'saturacion', 'glucosa', 'cardiaca', 'respiratoria', 'alergias', 'tipo', 'observaciones', 'diagnostico', 'tratamiento','area','subarea','nss','unidad_medica','consultorio','turno','vacuna','inmunizaciones','cirugia','herencia','tabaquismo','alcholismo','toxicomanias','areas_nombre','subareas_nombre']));
        $enfermedadesUsuario = usuario_enfermedad::where('rpe', $request->rpe)->pluck('enfermedades_cronicas_id')->toArray();

        // Recorrer las enfermedades seleccionadas
        $nuevasEnfermadades = array_diff($selectedEnfermedadesIds, $enfermedadesUsuario);
        foreach ($nuevasEnfermadades as $enfermedadId) {
            // Crear un nuevo registro
            usuario_enfermedad::create([
                'enfermedades_cronicas_id' => $enfermedadId,
                'rpe' => $request->rpe,
                'fecha_detectada' => $ant_per->updated_at->format('Y-m-d'),
            ]);
        }

        $eliminarEnfermedades = array_diff($enfermedadesUsuario, $selectedEnfermedadesIds);
        foreach ($eliminarEnfermedades as $enfermedadId) {
            // Eliminar el registro de usuario-enfermedad
            $enfermedadEliminar = usuario_enfermedad::where(['rpe' => $request->rpe, 'enfermedades_cronicas_id' => $enfermedadId])->first();
            $enfermedadEliminar->delete();
        }

        if(isset($request->origen)){
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }
        else{
            return redirect()->route('personales.indice', $ant_per->rpe);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $rpe)
    {
        $antecedentes_personales = Personales::findOrFail($id);

        // Encontrar enfermedades relacionadas al usuario del antecedente y eliminarlas
        $enfermedadesUsuario = usuario_enfermedad::where('rpe', $antecedentes_personales->rpe)->get();
        foreach ($enfermedadesUsuario as $enfermedad) {
            $enfermedad->delete();
        }

        $antecedentes_personales->delete();
        //$ev5->forceDelete();
        return redirect()->route('personales.indice', $rpe)->with('success', 'Expediente eliminada con éxito');
    }
    public function showAllAntecedentes(){
        $antecedentes = Personales::query()->with('user','user.getArea','user.getSubarea')
                                            ->whereHas('user', function($query) {
                                                $query->where('area', Auth::user()->datos->area);
                                            })->get();
        $divisiones = Division::all();
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        return view('personales.show-all-antecedentes',[
            'antecedentes'=>$antecedentes,
            'divisiones' => $divisiones,
            'areas' => $areas,
            'subareas' => $subareas,
        ]);
    }

    public function show_allAntecedentes(Request $request){
        $area = $request->area;
        $subarea = $request->subarea;
        $fecha_inicio = date($request->input('fecha_inicio'));
        $fecha_fin = date($request->input('fecha_fin'));
        $query = Personales::with('user','user.getArea','user.getSubarea');
        if ($area !== 'all'){
                $query->where('area', $area);
                // Verificar si el usuario seleccionó "Todas las subáreas"
                if ($subarea !== 'all') {
                    $query->where('subarea', $subarea);
                }
        }
        $query->whereBetween('created_at', [$fecha_inicio.' 00:00:00', $fecha_fin.' 23:59:59']);// Filtrar por fechas
        $antecedentesFiltrados = $query->get();
        return response()->json([
            'antecedentes' => $antecedentesFiltrados,
        ]);

    }

    public function estadisticaGeneral(Request $request){
        $permisoTodas = $request->user()->can('controlDivisional');
        if($permisoTodas){
            $areas = Area::where('division_id', 'DX')
                        ->where('area_clave', '!=', 'DXSU')
                        ->get();
        }
        else{
            $areas = Area::where('area_clave', Auth::user()->datos->area)->get();
        }


        return view('estadisticas.personales.general', [
            'areas' => $areas,
            'permisoTodas' => $permisoTodas
        ]);
    }

    public function filtrarPersonales(Request $request){
        $area = $request->area;
        $areas = $area == 'all'
                    ?
                        Area::where('division_id', 'DX')
                        ->where('area_clave', '!=', 'DXSU')
                        ->get()
                    :
                        Area::where('area_clave', $area)
                        ->get();

        $claves_areas = $areas->pluck('area_clave');
        $usuarios = Datosuser::whereIn('area', $claves_areas)->get();
        $rpesUsuariosZona = $usuarios->pluck('rpe');
        $notasMedicas = MiSalud::whereIn('rpe', $rpesUsuariosZona)->get();
        $audiometrias = $this->GetNegativosAudiometrias(Audiometria::whereIn('rpe', $rpesUsuariosZona)->get());
        $incapacidades = Incapacidad::whereIn('rpe', $rpesUsuariosZona)->get();
        $usuariosProSalud = ProSalud::whereIn('rpe', $rpesUsuariosZona)->get();
        $prosalud = $this->GetNegativosProsalud($usuariosProSalud);
        $imc = $this->GetNegativosIMC($notasMedicas);

        return response()->json([
            'notas' => $notasMedicas->count(),
            'imc' => $imc,
            // 'audiometrias' => $audiometrias,
            'incapacidades' => $incapacidades->count(),
            'glucosa' => $prosalud['Glucosa'],
            'trigliceridos' => $prosalud['Trigliceridos'],
            'colesterol' => $prosalud['Colesterol'],
            'hemoglobina' => $prosalud['Hemoglobina'],
            'leucocitos' => $prosalud['Leucocitos'],
            'plaquetas' => $prosalud['Plaquetas'],
            'total' => $usuarios->count(),
            'zona' => $request->area != 'all' ? $areas[0]: 'all'
        ]);
    }

    public function GetNegativosAudiometrias($audiometrias){
        return $audiometrias->sum(function($audiometria){
            return ($audiometria->oido_izquierdo != 1) && ($audiometria->oido_derecho != 1);
        });
    }

    public function GetNegativosIMC($notasMedicas){
        $imcMalo = $notasMedicas->sum(function($nota){
            return $nota->imc < 25;
        });
        return $imcMalo;
    }

    public function GetNegativosProsalud($usuarios){
        $bajos = $this->GetSintomasBajos($usuarios);
        $altos = $this->GetSintomasAltos($usuarios);

        return $bajos->map(function($parametro, $key) use($altos){
            return $parametro->count() + $altos[$key]->count();
        });
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
}
