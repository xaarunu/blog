<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class BlogController extends Controller
{
    
    public function index () {

        $blogs = Blog::all();
        
        return view('blogs.index', compact('blogs'));
    }	

    public function admin_index () {

        $blogs = Blog::all();
        
        return view('blogs.admin', compact('blogs'));
    }	


    public function crear () {

        return view('blogs.crear');
    }	


    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'contenido' => 'required|string',
            'rpe' => 'required|string', // Validación del RPE
           'prioridad' => 'required|in:1,2,3', // Validar que el valor esté entre 1 y 3
           'fecha_vencimiento' => 'required|date',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        'likes' => 'integer', 
        ]);


           // Procesar la imagen
        $rutaImagen = null;
            if ($request->hasFile('imagen')) {
        $rutaImagen = $request->file('imagen')->store('img/blogs', 'public');
        }

        Blog::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'rpe' => $request->rpe, // Guardar el RPE del usuario
            'prioridad' => $request->prioridad,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'imagen' => $rutaImagen, // Guardar la ruta de la imagen
            'likes' => $request->likes ?? 0, // Asignar 0 si no se ha proporcionado likes
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog creado exitosamente.');
    }



public function verBlog($id)
{
    $blog = Blog::findOrFail($id);
    return view('blogs.verBlog', compact('blog'));
}


public function editarBlog($id)
{
    $blog = Blog::findOrFail($id);
    return view('blogs.editarBlog', compact('blog'));
}




    // Guardar los cambios (actualización) solo para el admin
    public function editarGuardar(Request $request, $id)
    {
        // Validación de los campos
        $request->validate([
            'titulo' => 'required|string|max:100',
            'contenido' => 'required|string',
            'prioridad' => 'required|in:1,2,3', // Validar que el valor esté entre 1 y 3
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        // Obtener el blog por su ID
        $blog = Blog::findOrFail($id);
    
        // Asignar los nuevos valores
        $blog->titulo = $request->input('titulo');
        $blog->contenido = $request->input('contenido');
        $blog->prioridad = $request->input('prioridad');
    
        // Si hay una nueva imagen, procesarla y guardar la ruta
        if ($request->hasFile('imagen')) {
            // Guardar la nueva imagen
            $rutaImagen = $request->file('imagen')->store('img/blogs', 'public');
            $blog->imagen = $rutaImagen;
        }
    
        // Guardar los cambios
        $blog->save();
    
        // Redireccionar con mensaje de éxito
        return redirect()->route('blogs.index')->with('success', 'Blog editado exitosamente.');
    }
    

    // Eliminar el blog solo para el admin
    public function borrarBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog eliminado correctamente');
    }




public function testpdf ($id) {

    $blog = Blog::findOrFail($id);
      

    $pdf = PDF::loadView('blogs.tarjeta', compact('blog'));

    $pdf->setPaper('a4', 'portrait');

  return $pdf->download('blog-'.$blog->id.'.pdf');

  //return view('blogs.tarjeta' , compact('blog'));



}	




}
