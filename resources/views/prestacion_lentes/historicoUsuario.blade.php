<x-app-layout>
    @section('title', 'DCJ - CFE: Prestación de lentes')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de prestaciónes de ' . $usuario->getNombreCompleto()) }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
        <style>
            .prestacion-activa { font-weight: bold; color: green; }
            .prestacion-inactiva { color:red; }
            .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
            .alert-error { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        </style>
    @endsection

    <div class="py-10">
        <x-boton-regresar />

        {{-- Flash msg --}}
        @if (Session::has('message'))
            <div class="alert-{{ session('message_type') }} border rounded-lg w-80 md:w-1/2 mx-auto py-8 px-4 my-4" role="alert">
                {{ session('message') }}
            </div>
        @endif
        
        {{-- Tabla --}}
        <div class="mx-auto sm:px-6 lg:px-8 w-11/12 md:w-9/12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 w-full">
                <table id="data-table" class="stripe hover translate-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Fecha de asignación</th>
                            <th>Archivo relacionado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $registro)
                            <tr>
                                @php
                                    $ultimaFechaActiva = date('Y-m-d', strtotime('-365 days'));
                                    // Posibles "estatus": *Sin registros previos, *Registro vencido, *Registro activo
                                    $estatus = ($registro->fecha_asignacion >= $ultimaFechaActiva) ? 'prestacion-activa' : 'prestacion-inactiva';
                                @endphp
                                <td>{{ $usuario->getArea->area_nombre }}</td>
                                <td class="{{ $estatus }}">{{ $registro->fecha_asignacion }}</td>
                                <td>
                                    @if($archivo = $registro->archivo)
                                        <a class="text-blue-600" target="_blank" href="{{ asset($archivo->getFilePath()) }}">{{ $archivo->nombre_archivo }}</a>
                                    @else
                                        <span>Sin archivo relacionado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-center items-center rounded-lg gap-2 empty:hidden" role="group">
                                        <a class="py-2 px-4 rounded-lg text-white font-bold bg-blue-500 hover:bg-blue-600"
                                            href="{{ route('lentes.show', $registro->id) }}">Ver</a>
                                        @can('prestacion.edit')
                                            <a class="py-2 px-4 rounded-lg text-white font-bold bg-yellow-500 hover:bg-yellow-600"
                                            href="{{ route('lentes.edit', $registro->id) }}">Editar</a>
                                        @endcan
                                        @can('prestacion.delete')
                                            <form id="formEliminar-{{ $registro->id }}" method="POST" action="{{ route('lentes.destroy', $registro->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $registro->id }});" class="py-2 px-4 rounded-lg text-white font-bold bg-red-500 hover:bg-red-600">Eliminar</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex items-center justify-center  md:gap-8 gap-4 pb-5" style="display:flex; gap:10px;">
                    <!-- botón volver -->
                    <a type="button" href="{{ url()->previous() }}" style="text-decoration:none"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <!-- botón crear -->
                    @can('prestacion.create')
                    <a type="button" href="{{ route('lentes.create', ['rpe'=> $usuario->rpe]) }}" style="text-decoration:none"
                        class="rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4">Crear</a>
                    @endcan
                </div>
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
{{-- Ocultar alertas automaticamente --}}
<script>
    $('document').ready(function () {
        $('[role="alert"]').delay(2500).slideUp(300);
    });
</script>
<script>
    "use strict";
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
