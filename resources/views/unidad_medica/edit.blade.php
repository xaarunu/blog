<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Unidades medicas') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection


    <x-boton-regresar />

    <div class="col-sm-12">
        @if($mensaje = Session::get('success'))
            <div class="alert alert-success" role="alert">
            {{ $mensaje }}
            </div>
        @endif
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4 mt-4 mb-4 ml-11"
        style="width:95%; margin-right:auto; margin-left:auto ">

        <!-- Agrega un formulario para crear una nueva unidad médica -->
        {{-- action="{{ route('unidad_medica.update', $unidadMedica->id) }}" --}}
        <form  action="{{ route('unidad_medica.update', $unidadMedica->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $unidadMedica->nombre }}" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado"  value="{{ $unidadMedica->estado }}" required>
            </div>
            <div class="mb-3">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" name="municipio" value="{{ $unidadMedica->municipio }}"  required>
            </div>
            <button type="submit" class="btn btn-success bg-green-500 hover:bg-green-600">Actualizar Unidad Médica</button>
        </form>


    </div>
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js')}}"></script>
    @endsection
</x-app-layout>
