<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Datosuser;
use App\Models\Division;
use App\Models\Subarea;
use App\Models\User;
use App\Models\UsuarioPendiente;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuarioPendienteController extends Controller
{
    public function __construct() {
        $this->middleware('can:users.autorizar')->only('index', 'edit', 'update', 'destroy', 'autorizar');
    }

    public function index() {
        $usuarios = UsuarioPendiente::with(['user', 'user.roles'])->get();

        $usuariosPendientes = $usuarios->map(function ($dato) {
            return [
                'id' => $dato->id,
                'rpe' => $dato->user->rpe,
                'nombre' => implode(' ', $dato->only(['nombre', 'paterno', 'materno'])),
                'correo' => $dato->user->email,
                'puesto' => $dato->puesto,
                'centro' => $dato->subarea,
                'estatus' => $dato->user->estatus,
                'roles' => $dato->user->roles,
            ];
        });

        return view('users.pendientes.index', ['users' => $usuariosPendientes]);
    }

    public function show($id) {
        $datos = UsuarioPendiente::findOrFail($id);
        $user = User::where('rpe', $datos->rpe)->firstOrFail();
        
        $divisiones = Division::all();
        $areas = Area::where('division_id', 'lIKE', $datos->division . '%')->get();
        $subareas = Subarea::where('area_id', 'lIKE', $datos->area . '%')->get();
        
        $roles = Role::all();
        return view('users.pendientes.show', compact('id', 'user', 'divisiones', 'areas', 'subareas', 'datos' ,'roles'));
    }

    public function update(Request $request, $id) {
        $user = User::FindOrFail($id);
        $datosPendientes = UsuarioPendiente::where('rpe', $user->rpe)->firstOrFail();

        $user->syncRoles($request->roles);
        $user->fill($request->all());
        $user->save();
        $datosPendientes->fill($request->all());
        $datosPendientes->save();
        
        return redirect()->route('users.autorizar', $datosPendientes->id);
    }

    public function destroy($id) {
        $datosPendientes = UsuarioPendiente::findOrFail($id);
        $user = User::where('rpe', $datosPendientes->rpe)->firstOrFail();

        if($user->estatus == 1) {
            $user->forceDelete();
        }

        $datosPendientes->delete();

        return redirect()->route('users.pendientes.index')->with('message', 'Cambio rechazado');
    }

    public function autorizar($id) {
        $datosPendientes = UsuarioPendiente::findOrFail($id);
        $user = User::where('rpe', $datosPendientes->rpe)->firstOrFail();

        // estatus 1:Pendiente (nuevo), 3:Modificación Pendiente
        if ($user->estatus == 1) {
            $registro = new Datosuser($datosPendientes->toArray());
        } else {
            $registro = Datosuser::where('rpe', $user->rpe)->first();
            $registro->fill($datosPendientes->toArray());
        }

        $registro->save();

        $user->estatus = 2;
        $user->save();
        
        $datosPendientes->delete();

        return redirect()->route('users.pendientes.index')->with('message', 'Cambio autorizado correctamente!');
    }
}
