<?php

namespace App\Http\Controllers;

use App\Models\UnidadesMedicas;
use Illuminate\Http\Request;

class UnidadMedicaController extends Controller
{
    public function index() {
        // Lógica para mostrar una lista de unidades médicas
        $unidadesMedicas = UnidadesMedicas::all();
        return view('unidad_medica.index', compact('unidadesMedicas'));
    }

    public function created(Request $request) {
        // Validación de datos
        
        return view('unidad_medica.created');
        //return redirect()->route('unidad_medica.created')->with('success', 'Unidad Médica creada con éxito');
    }     // Lógica para mostrar el formulario de creación
   

    public function store(Request $request) {
        // Valida los datos enviados desde el formulario
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'municipio' => 'required',
        ]);

        // Obtener los datos del formulario
        $unidadMedica = new UnidadesMedicas();
        $unidadMedica->nombre = $request->input('nombre');
        $unidadMedica->estado = $request->input('estado');
        $unidadMedica->municipio = $request->input('municipio');

        
        $unidadMedica->save();

        // Redirigir a una página de éxito o hacer cualquier otra acción necesaria
        return redirect()->route('unidad_medica.created')->with('success', 'Unidad medica creada con éxito');
        info($request);
 
     }

    public function edit($id) {
        // Lógica para mostrar el formulario de edición
        $unidadMedica = UnidadesMedicas::findOrFail($id);
        return view('unidad_medica.edit', compact('unidadMedica'));
    }

    public function update(Request $request, $id)
    {
        
        $unidad = UnidadesMedicas::find($id);
        $unidad->nombre = $request->input('nombre');
        $unidad->estado = $request->input('estado');
        $unidad->municipio = $request->input('municipio');
        $unidad->save();
        $unidadesMedicas = UnidadesMedicas::all();
        return redirect()->route('unidad_medica.index')->with('success', 'La unidad médica se actualizó correctamente.');
        return view('unidad_medica.index', compact('unidadesMedicas'));
    // return redirect('/unidades-medicas');
    }
    public function destroy(Request $request, $id) {
        // Obtener el registro a eliminar
        $unidadMedica = UnidadesMedicas::findOrFail($id);
        // Eliminar el registro de la base de datos
        $unidadMedica->delete();
        // Redirigir a la página de la lista de registros
        $unidadesMedicas = UnidadesMedicas::all();
        return redirect()->route('unidad_medica.index')->with('success', 'Registro eliminado con éxito');
        return view('unidad_medica.index', compact('unidadesMedicas'));
    }
 
}
