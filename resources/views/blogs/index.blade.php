<x-app-layout>
    @section('title', 'Blogs - CFE')
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

   
     <u1>
        <div class="mx-auto mt-4  sm:px-6 lg:px-8 py-3 lg:w-8/12 w-11/12 leading-normal rounded-lg flex justify-around">
            <a href="{{ route('blogs.crear') }}"
                class='w-auto bg-green-500 hover-bg-green-600 rounded-lg shadow-xl font-medium text-white px-6 py-2'>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                     d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                     clip-rule="evenodd" />
                </svg>
                Nuevo blog
        </a>

        <br>

        @if(Auth::user()->hasRole(['admin']))
            <a href="{{ route('blogs.admin') }}"
                class='w-auto bg-green-500 hover-bg-green-600 rounded-lg shadow-xl font-medium text-white px-6 py-2'>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                     d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                     clip-rule="evenodd" />
                </svg>
                Administrar publicaciones
        </a>
    @endif

    </div>
    </u1>
      
    
 
        @if (Session::has('message'))
            <div class="alert-success w-80 md:w-1/2 mx-auto py-8 px-4" role="alert">
                {{ session('message') }}
            </div>
        @endif
      
  
        @if ($blogs->isEmpty())
        <p>No hay blogs disponibles.</p>
    @else
        <u2>
            @foreach ($blogs as $blog)

                <a href="{{ route('blogs.verBlog', ['id' => $blog->id]) }}" style="text-decoration: none; color: inherit;">
                    <div class="mt-4 mx-auto sm:px-6 lg:px-8" style="width:60rem;">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%; padding: 2rem; 
                            border: 1px solid 
                            @if ($blog->prioridad == 1) red 
                            @elseif ($blog->prioridad == 2) yellow 
                            @elseif ($blog->prioridad == 3) green 
                            @endif;">
                            
                            <!-- Mostrar la imagen -->
                            @if ($blog->imagen)
                                <img src="{{ asset('storage/' . $blog->imagen) }}" alt="Imagen del blog" style="width: 100px; height: auto; margin-bottom: 1rem;">
                            @endif
                            
                            <h2><strong>{{ $blog->titulo }}</strong></h2>
                            <p>{{ \Illuminate\Support\Str::limit($blog->contenido, 100) }}</p>
                            <p><strong>Autor RPE:</strong> {{ $blog->rpe }}</p>
                            <p><em>Creado el: {{ $blog->created_at }}</em></p>
                        </div>
                    </div>
                </a>
            @endforeach

        </u2>
    @endif
    
    
    

    @section('js')
    <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/customDataTables.js') }}"></script>
@endsection


</x-app-layout>