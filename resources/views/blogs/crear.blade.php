<x-app-layout>
    @section('title', 'Crear blog - CFE')
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

   
    
       <div class="ml-40 mt-4 px-4 py-3 lg:w-8/12 w-11/12 leading-normal text-green-500 rounded-lg">
            <div class="text-left">
                <a href="{{ route('blogs.index') }}"
                    class='w-auto bg-green-500 hover-bg-green-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                         d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                         clip-rule="evenodd" />
                    </svg>
                    Regresar
            </a>
            </div>
        </div>
    
      
      
        <div class="mt-4 mx-auto sm:px-6 lg:px-8" style="width:60rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                <form id="formEnviarBlog" action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
        
                    <div class="grid grid-cols-1 mt-5 mx-7">
                        <label class="uppercase md:text-sm text-xs text-black font-semibold">RPE:</label>
                        <input name="rpe" type="hidden" maxlength="5" value="{{ auth()->user()->rpe }}"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required />
                        @error('rpe')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="grid grid-cols-1 mt-5 mx-7">
                        <label class="uppercase md:text-sm text-xs text-black font-semibold">Título:</label>
                        <input name="titulo" value="{{ old('titulo') }}" 
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required />
                        @error('titulo')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="grid grid-cols-1 mt-5 mx-7">
                        <label class="uppercase md:text-sm text-xs text-black font-semibold">Contenido:</label>
                        <input name="contenido" value="{{ old('contenido') }}" 
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required />
                        @error('contenido')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="grid grid-cols-1 mt-5 mx-7">
                        <label class="uppercase md:text-sm text-xs text-black font-semibold">Fecha de Vencimiento:</label>
                        <input name="fecha_vencimiento" type="date" value="{{ old('fecha_vencimiento') }}"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required />
                        @error('fecha_vencimiento')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="grid grid-cols-1 mt-5 mx-7">
                        <label class="uppercase md:text-sm text-xs text-black font-semibold">Imagen:</label>
                        <input name="imagen" type="file"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
                        @error('imagen')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="grid grid-cols-1 mt-5 mx-7">
                        <label class="uppercase md:text-sm text-xs text-black font-semibold">Prioridad:</label>
                        <select name="prioridad" required
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent">
                            <option value="">Selecciona una prioridad</option>
                            <option value="1">Urgente</option>
                            <option value="2">Media</option>
                            <option value="3">No Urgente</option>
                        </select>
                        @error('prioridad')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <br>
                    <div class='flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('blogs.index') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit"
                            class='w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        

    @section('js')
    <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/customDataTables.js') }}"></script>
@endsection


</x-app-layout>