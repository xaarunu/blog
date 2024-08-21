<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Unidades medicas') }}
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
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6"
        style="width:95%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto ">

        <table id="data-table" class="stripe hover translate-table"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-white">
                <tr class="bg-gray-800 text-white">
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Municipio</th>
                    <th>Creacion</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($unidadesMedicas as $unidadMedica)
                    <tr>
                        <td>{{$unidadMedica->id}}</td>
                        <td>{{$unidadMedica->nombre}}</td>
                        <td>{{$unidadMedica->estado}}</td>
                        <td>{{$unidadMedica->municipio}}</td>
                        <td>{{ $unidadMedica->created_at?->format('Y-m-d') }}</td>
                        <td>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <a href="{{ route('unidad_medica.edit', $unidadMedica->id) }}" class="text-white">Editar</a>
                            </button>
                            <form id="formEliminar-{{ $unidadMedica->id }}" action="{{ route('unidad_medica.destroy', $unidadMedica->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="confirmDelete({{ $unidadMedica->id }});" type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js')}}"></script>
    @endsection
</x-app-layout>
<script>
    'use strict';

    // Función encargada de mostrar alerta para confirmar eliminación de un registro
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Confirma la eliminación del registro?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`formEliminar-${id}`).submit();
                Swal.fire('¡Eliminado!'
                    , 'El registro ha sido eliminado exitosamente.', 'success');
            } else {
                //Se oculta el loader para que no tape toda la pantalla por siempre.
                loader.style.display = "none";
            }
        })
    }
</script>
