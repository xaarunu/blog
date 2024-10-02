<x-app-layout>
    @section('title', 'BLOGS - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>


    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">
     
        @if (Session::has('message'))
            <div class="alert-{{ session('message_type') }} w-80 md:w-1/2 mx-auto py-8 px-4" role="alert">
                {{ session('message') }}
            </div>
        @endif

{{-- 
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">
            <div class="grid grid-cols-1 ">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">AUTOR(RPE):</label>
                <select id="_division_filtro" name="division_filtro"
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                
                </select>
            </div>
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha de publicación:</label>
                <select id="_area_filtro" name="area_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                
                </select>
            </div>
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha límite:</label>
                <select id="_subarea_filtro" name="subarea_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                
                </select>
            </div>
        
        </div>
        <br>
        <div class="grid grid-rows-1 place-items-center mt-3">
            <!-- botón Filtrar -->
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            <button onClick="filter()" style="text-decoration:none;"
                class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
        </div>
        <br>
         --}}

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <!--            <button type="submit" class="rounded text-white font-bold py-2 px-4">Borrar</button> -->

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">

                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>RPE</th>
                            <th>Titulo</th>
                            <th>Contenido</th>
                            <th>Creado en:</th>
                
                            <th class="none">Acciones</th>
                            </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($blogs as $blog )
                            
                           <tr data-id="{{ $blog->rpe }}">
                                    <td class="px-6 py-4 text-left mostrar-usuario">
                                        <div>
                                            {{ $blog->rpe }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-left mostrar-usuario">
                                        <div>
                                            {{ $blog->titulo }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-left mostrar-usuario">
                                        <div>
                                            {{ \Illuminate\Support\Str::limit($blog->contenido, 40) }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-left mostrar-usuario">
                                        <div>
                                            Creado el: {{ $blog->created_at }}
                                        </div>
                                    </td>

                          
                                   
                                    <td class="px-4 py-2">
                                        <div class="flex justify-center rounded-lg text-lg" role="group">
                                           
                                                <a href="{{ route('blogs.editarBlog', $blog->id) }}"
                                                    style="text-decoration: none"
                                                    class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 mx-1">Editar</a>
                                          
                                           
                                                    <form action="{{ route('blogs.borrarBlog', $blog->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class='w-auto bg-red-500 hover:bg-green-600 rounded-lg shadow-xl font-medium text-white px-6 py-2' >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                    
                                         
                                           
                                           
                                        </div>
                                    </td>
                                

                                    </td>

                        @endforeach
                             
                                   
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection

</x-app-layout>