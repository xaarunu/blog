<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nota Médica de '.$datosusers->nombre." ".$datosusers->paterno." ".$datosusers->materno ) }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection
    
    <x-boton-regresar />
    
    @if(isset($tiene_antecedente))
        @if(!$tiene_antecedente)
            <div class="alert" style=" background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
                <p style="color: #571515;">No se encontró un antecedente para el RPE especificado. Por favor, crea un antecedente. 
                    <a id="a1" style="all: revert" href="{{ route('personales.create',$datosusers->rpe) }}">Crear Antecedente</a>
                </p>
            </div>
        @endif
    @endif
   
    <div class="py-10">
        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th align="center">RPE</th>
                            <th align="center">Fecha de creación</th>
                            <th align="center">Sexo</th>
                            <th align="center">Observaciones</th>
                            <th class="none">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($miSalud as $sal)
                            <tr data-id="{{ $sal->id }}">

                                <td align="center">{{ $sal->rpe }}</td>
                                <td align="center">{{ $sal->fecha }}</td>
                                <td align="center">{{ $sal->sexo }}</td>
                                <td align="center">{{ $sal->observaciones }}</td>
                                <td>
                                    <div class="flex justify-center rounded-lg text-lg" role="group" style="display:flex; gap:10px;">
                                        <!-- Botón Ver -->
                                        <a style="text-decoration: none" href="{{ route('saluds.edit', $sal->id) }}"
                                            style="text-decoration: none"
                                            class="rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 mx-auto">Ver</a>
                                        <!-- Botón Borrar -->
                                        <form id="formEliminar-{{ $sal->id }}" action="{{ route('saluds.destroy', $sal->id) }}" method="POST"
                                            class="rounded-lg bg-red-600 hover:bg-red-700 mx-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $sal->id }});"
                                                class="rounded-lg text-black font-bold py-2 px-4 mx-auto">Borrar</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="flex items-center justify-center  md:gap-8 gap-4 pb-5">
                    <!-- botón volver -->
                    <a type="button" href="{{ route('datos.index') }}" style="text-decoration:none"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <!-- botón crear -->
                    <a type="button" href="{{ route('saluds.create', ['rpe' => $datosusers->rpe]) }}" style="text-decoration:none"
                        class="rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4"> Crear</a>
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
