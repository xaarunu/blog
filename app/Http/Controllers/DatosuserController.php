<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\Area;
use App\Models\User;
use App\Models\Datosuser;
use App\Models\Subarea;
use App\Models\Division;
use App\Models\UnidadesMedicas;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\enfermedades_cronicas;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DatosuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasAnyRole(['admin', 'Doctora', 'RecursosHumanos', 'JefeRecursosHumanos']))
        {
            $areas = Area::where('division_id', Auth::user()->datos->division)->get();
            $subareas = Subarea::where('area_id', Auth::user()->datos->area)->get();
            
            $datosuser = Datosuser::where('division', Auth::user()->datos->division)
                                    ->where('area', Auth::user()->datos->area)
                                    ->get();

            $unidades_medicas = UnidadesMedicas::all();
            $enfermedades = enfermedades_cronicas::all();
            $enfermedadesPermiso = Auth::user()->hasRole(['admin', 'Doctora']);
            return view('datos.index', compact('datosuser', 'areas', 'subareas', 'unidades_medicas', 'enfermedades', 'enfermedadesPermiso'));
        }
        else
        {
            return abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        if(Auth::user()->hasRole('admin'))
        {
            $divisiones = DB::table('divisiones')->get();
            $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
            $subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', 'DX00' . '%')->get();
            /**$datosuser = DB::table('datosusers')->get();*/
            return view('datos.crear',['areas' => $areas, 'subareas' => $subareas, 'divisiones' => $divisiones]);
        }
        else
        {
            return abort(403);
        }
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
            'rpe' => 'max:5|unique:App\Models\Datosuser',
            'email' => 'required|unique:App\Models\User',
            'nombre' => 'required|max:191',
            'paterno' => 'required|max:191',
            'materno' => 'required|max:191',
            'ingreso' => 'required|date|before:tomorrow',
            'area' => 'required',
            'subarea' => 'required',
        ]);
        
        $area = $request->input('area');
        $subarea = $request->input('subarea');
        $du = $request->all();
        Datosuser::create($du);
        return redirect()->route('datos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Datosuser  $datos
     * @return \Illuminate\Http\Response
     */
    public function show(Datosuser $datos)
    {
        return view('datos.editar', compact('datos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Datosusers  $datos
     * @return \Illuminate\Http\Response
     */
    public function edit($datos)
    {
        /**$datosuser = DB::table('datosusers')->get();*/
        if(Auth::user()->hasRole('admin'))
        {
            $datos = Datosuser::where('id',$datos)->firstOrFail();
            $datosuser = DB::table('datosusers')->get(); 

            $divisiones = DB::table('divisiones')->get();
            $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
            $subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', 'DX00' . '%')->get();

            return view('datos.editar', ['areas' => $areas, 'subareas' => $subareas, 'divisiones' => $divisiones], compact('datos'));
        }
        else
        {
            return abort(403);   
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Datosuser  $datosuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rpe' => 'required|max:5|unique:App\Models\Datosuser,rpe,'.$id,
            'nombre' => 'required|max:191',
            'paterno' => 'required|max:191',
            'materno' => 'required|max:191',
            'ingreso' => 'required|date|before:tomorrow',
        ]);
        /*$user = User::FindOrFail($id);
        $user->rpe = $request->rpe;
        $user->save();
        $datos = Datosuser::FindOrFail($id);
        $datos->fill($request->all());
        $datos->save();*/
        
        $datos = DatosUser::FindOrFail($id);
        $userRPE = DB::table('users')->where('rpe', $datos->rpe)->first();
        $user = User::FindOrFail($userRPE->id);
        $user->rpe = $request->rpe;
        $user->save();
        $datos->fill($request->all());
        $datos->save();

        if(isset($request->origen)){
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }
        else{
            return redirect()->route('datos.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Datosuser  $datosuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Datosuser $datos)
    {
        $datos->forceDelete();
        return redirect()->route('datos.index');
    }

    public function bajar(Request $request, Datosuser $datos)
    {    
        $datos = Datosuser::FindOrFail($request['id']);
        $datos->delete();
        return redirect()->route('datos.index');
    }

    public function buscarUsuario($usuario)
    {
        // Se utiliza el método where para buscar un registro en la tabla 'datosusers' con el rpe igual a $usuario.
        $usuari = Datosuser::where('rpe', $usuario)->first();
        $usuari['roles'] = User::where('rpe', $usuario)->first()->roles->pluck('name', 'id');

        // Si se encontró un registro, se devuelve como resultado. Si no se encontró, se devuelve null utilizando el operador de fusión de null.
        return $usuari ?? null;
    }

    public function filtrarUsuarios(Request $request)
    {
        $division = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $unidad_medica = $request->unidad_medica;
        $enfermedad = $request->enfermedad;

        $datosuser = Datosuser::query()
        ->with(['getArea', 'getSubarea', 'unidad_medica', 'user', 'user.enfermedadesCronicas.enfermedadCronica'])
        ->when($division != '0', function($query) use ($division)
        {
            return $query->where('division', $division);
        })
        ->when($area != '0', function($query) use ($area)
        {
            return $query->where('area', $area);
        })
        ->when($subarea != '0', function($query) use ($subarea)
        {
            return $query->where('subarea', $subarea);
        })
        ->when($unidad_medica != '0', function($query) use ($unidad_medica)
        {
            return $query->whereHas('unidad_medica', function ($query) use ($unidad_medica) {
                return $query->where('id', $unidad_medica);
            });
        })
        ->when($enfermedad != '0', function($query) use ($enfermedad)
        {
            return $query->whereHas('user.enfermedadesCronicas.enfermedadCronica', function ($query) use ($enfermedad) {
                return $query->where('id', $enfermedad);
            }); 
        })
        ->get();
        //info($datosuser);

        return response()->json([
            'users' => $datosuser,
            'enfermedadesPermiso' => Auth::user()->hasRole(['admin', 'Dcotroa']),
            'success' => true,
        ]);
    }
}
