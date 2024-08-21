<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\Division;
use Illuminate\Support\Facades\DB;
use App\Models\Datosuser;
use App\Models\Subarea;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Contratos;
use App\Models\Evidencia;
use App\Models\UsuarioPendiente;
use Database\Seeders\AreaSeeder;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index', 'inicio');
        $this->middleware('can:users.edit')->only('edit', 'update');
        $this->middleware('can:users.create')->only('create', 'store');
        $this->middleware('can:users.destroy')->only('destroy');
        $this->middleware('can:users.datosPersonales')->only('datosPersonales');
        $this->middleware('can:users.usuariosBaja')->only('usuariosBaja');
    }

    public function index()
    {
        $divisiones = Division::all();
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        $datos = Datosuser::query()
            ->where('subarea', Auth::user()->datos->getSubarea->subarea_clave)
            ->get();
        $datos = $datos->keyBy('rpe');

        $datos_rpe = Datosuser::query()
            ->where('subarea', Auth::user()->datos->getSubarea->subarea_clave)
            ->pluck('rpe');

        $users = User::query()
            ->whereIn('rpe', $datos_rpe)
            ->where('estatus', 2) // Usuarios en estatus "Autorizado"
            ->get()->map(function ($user) {
                $user->roles_J = $user->roles;
                return $user;
            });

        $roles = Role::all();

        return view('users.index', compact('users', 'roles', 'datos', 'divisiones', 'areas', 'subareas'));
    }
    public function updateTable(Request $request)
    {
        $div = $request->division;
        $area = $request->area;
        $sec = $request->seccion;
        $rol = $request->rol;

        $documentos = Datosuser::query()
            ->with(['divisiones', 'areas', 'secciones', 'roles'])
            ->where('division', $div)
            ->get();
        return response()->json(
            [
                'success' => true,
                'lista' => $documentos,
            ]
        );
    }
    public function updateTableIndex(Request $request)
    {
        $div = $request->division;
        $area = $request->area;
        $rol = $request->rol;
        $sec = $request->seccion;

        //info($div . '-' . $area . '-' . $subarea . '-' . $sec . '-' . $doc . '-' . $year . '-' . $month);
        $usuarios = Datosuser::query()
            ->with(['divisiones', 'areas', 'subareas', 'secciones'])
            ->where('division', $div)
            ->where('area', $area)
            ->when($rol != '0', function ($query) use ($rol) {
                return $query->where('subarea', $rol);
            })
            ->when($sec != '0', function ($query) use ($sec) {
                return $query->where('seccion', $sec);
            })->get();
        ////info($evidencias);
        return response()->json(
            [
                'success' => true,
                'lista' => $div,
            ]
        );
    }

    public function index_Specification()
    {
        $datos = Datosuser::all();
        $datos = $datos->keyBy('rpe');
        $divisiones = DB::table('divisiones')->get();
        $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
        $secciones = DB::table('secciones')->get();

        $users = User::all();

        $roles = Role::all();
        return view('users.index', compact('users', 'roles', 'datos', 'divisiones', 'areas', 'secciones'));
    }

    public function datosPersonales()
    {
        $datos = Datosuser::where('rpe', Auth::user()->rpe)->firstOrFail();
        $correo = DB::table('users')->select('email')->where('rpe', Auth::user()->rpe)->first();
        $division = DB::table('divisiones')->select('division_nombre')->where('division_clave', str_split($datos->area, 2)[0])->first();
        $contrato = $datos['contrato'] ? Contratos::where('cl_tipco', $datos['contrato'])->first()['tipocontrato'] : 'Sin contrato';
        $area = $datos['area'] ? Area::where('area_clave', $datos->area)->first()['area_nombre'] : 'Sin area';
        $subarea = $datos['subarea'] ? Subarea::where('subarea_clave', $datos->subarea)->first()['subarea_nombre'] : 'Sin subarea';

        return view('users.datos-personales', compact('datos', 'correo', 'division', 'contrato', 'area', 'subarea'));
    }

    public function usuariosBaja()
    {
        $users = Datosuser::where('contrato', '3')->orWhere('contrato', '4')->get();
        $areas = Area::all();
        $subareas = Subarea::all();
        return view('users.usuariosBaja', compact('users', 'areas', 'subareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $divisiones = $user->hasRole('admin') ? Division::all() : Division::where('division_clave', $user->datos->division)->get();
        $areas = $user->can('controlDivisional') ? $user->datos->getDivision->areas : Area::where('area_clave', $user->datos->area)->get();
        $subareas = $user->datos->getArea->subareas;
        $roles = $user->hasRole('admin') ?
                Role::all() :
                Role::whereNotIn('name', ['admin'])->get();

        return view('users.crear', compact('areas', 'subareas', 'divisiones' ,'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($request->password)){
            $request->request->add(['password' => 'password']);  // Contraseña por default
        }
        $request->validate([
            'rpe' => 'required|unique:users,rpe',
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'ingreso' => 'required',
            'contrato' => 'required',
            'area' => 'required',
            'subarea' => 'required',
            'division' => 'required',
            'roles' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|confirmed|min:8',
        ]);

        $request['password'] = bcrypt($request->password);
        $request['antiguedad'] = $request->ingreso;

        $user = new User($request->only(['rpe', 'email', 'password']));

        $user->assignRole($request->roles);

        if (Auth::user()->can('users.autorizar')) {
            $datos = new Datosuser($request->except(['rpe', 'email', 'password', 'ingreso']));
            $user->estatus = 2; // Autorizar usuario directamente
            $user->datos()->save($datos);

            session()->flash('message', 'El usuario se registrado correctamente!');
            session()->flash('message_type', 'success');
        } else {
            UsuarioPendiente::create($request->except(['email', 'password', 'ingreso']));

            session()->flash('message', 'Enviado correctamente. Se necesita la autorización del jefe de División.');
            session()->flash('message_type', 'info');
        }

        $user->save();

        return redirect()->route('users.index');
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

    public function centros(){
        $divisiones = DB::table('divisiones')->get();
        $areas = DB::table('areas')->where('division_id',$divisiones[0]->division_clave)->get();
        $subareas = DB::table('subareas')->where('area_id',$areas[0]->area_clave)->get();
        return view('users.centros',compact('divisiones','areas','subareas'));
    }

    public function areas(Request $request){
        $areas = DB::table('areas')->where('division_id',$request->division)->get();
        return response()->json(
            [
                'success' => true,
                'lareas' => $areas,
            ]
        );
    }
    public function subareas(Request $request){
        $subareas = DB::table('subareas')->where('area_id',$request->area)->get();
        return response()->json(
            [
                'success' => true,
                'lsubarea' => $subareas,
            ]
        );
    }

    public function filterUsers(Request $request)
    {
        $div = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $rol = $request->rol;

        $datos = Datosuser::query()
            ->where('division', $div)
            ->when($area != 0, function($query) use($area){
                return $query->where('area', $area);
            })
            ->when($subarea != 0, function ($query) use ($subarea) {
                return $query->where('subarea', $subarea);
            })
            ->get();
        $datos = $datos->keyBy('rpe');

        $datos_rpe = Datosuser::query()
            ->where('division', $div)
            ->when($area != 0, function($query) use($area){
                return $query->where('area', $area);
            })
            ->when($subarea != 0, function ($query) use ($subarea) {
                return $query->where('subarea', $subarea);
            })
            ->pluck('rpe');
        $users = User::query()
            ->whereIn('rpe', $datos_rpe)
            ->when($rol != 0, function ($query) use ($rol) {
                return $query->whereHas('roles', function ($query) use ($rol) {
                    $query->where('name', $rol);
                });
            })
            ->get()
            ->map(function ($user) {
                $user->role_J = $user->getRoleNames()->first();
                return $user;
            });
        $roles = Role::all();
        //info($users[0]);
        return response()->json(
            [
                'success' => true,
                'users' => $users,
                'datos' => $datos,
                'roles' => $roles,
            ]
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userLogged = Auth::user();
        $user = User::FindorFail($id);
        $datos = Datosuser::where('rpe', $user->rpe)->firstOrFail();

        $divisiones = $userLogged->hasRole('admin') ? Division::all() : Division::where('division_clave', $userLogged->datos->division)->get();
        $areas = $userLogged->can('controlDivisional') ? $userLogged->datos->getDivision->areas : Area::where('area_clave', $userLogged->datos->area)->get();
        $subareas = $userLogged->datos->getArea->subareas;

        $roles = $userLogged->hasRole('admin') ?
                Role::all() :
                Role::whereNotIn('name', ['admin'])->get();

        return view('users.editar', compact('user', 'divisiones', 'areas', 'subareas', 'datos' ,'roles'));
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
        $user = User::FindOrFail($id);
        $datos = Datosuser::where('rpe', $user->rpe)->firstOrFail();

        $request->validate([
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'ingreso' => 'required',
            'contrato' => 'required',
            'area' => 'required',
            'subarea' => 'required',
            'division' => 'required',
            'roles' => 'required',
        ]);

        $request['antiguedad'] = $request->ingreso;

        $user->syncRoles($request->roles);

        if (Auth::user()->can('users.autorizar')) {
            $user->fill($request->all());
            $datos->fill($request->all());
            $user->estatus = 2; // Autorizar cambios directamente

            $datos->save();

            session()->flash('message', 'El usuario se modifico correctamente!');
            session()->flash('message_type', 'success');
        } else {
            UsuarioPendiente::create($request->except(['email', 'password', 'ingreso']));

            session()->flash('message', 'Enviado correctamente. Se necesita la autorización del jefe de División.');
            session()->flash('message_type', 'info');
        }

        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->forceDelete();
        return redirect()->route('users.index');
    }

    public function bajar(Request $request)
    {
        $user = User::FindOrFail($request['id']);
        $user->delete();
        return redirect()->route('users.index');
    }

    public function inicio()
    {
        // $vc = DB::table('view_counter')->where('pagina', 'usuarios')->first()->visitas + 1;
        // DB::table('view_counter')->where('pagina', 'usuarios')->update(['visitas'=>$vc]);
        return view('users.inicio');
    }
}
