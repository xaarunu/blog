<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitar vacaciones vacaciones fuera de programa') }}
        </h2>
    </x-slot>
    <style>
        /* CHECKBOX TOGGLE SWITCH */
        /* @apply rules for documentation, these do not work as inline style */
        .toggle-checkbox:checked {
            @apply: right-0 border-green-600;
            right: 0;
            border-color: #68D391;
        }

        .toggle-checkbox:checked+.toggle-label {
            @apply: bg-green-400;
            background-color: #68D391;
        }
    </style>
    @section('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> --}}
    @endsection

    <div class="py-10">
        <x-boton-regresar />
        <form action="{{ route('solicitarfuera.store') }}" method="POST" enctype="multipart/form-data"
            class="formEnviar">

            @csrf
            @if ($errors->count() > 0)
                <div id="ERROR_COPY" style="display:none " class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br />
                    @endforeach
                </div>
            @endif

            <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
                <label
                class="flex items-center justify-center w-auto bg-green-400 hover:bg-white-500 rounded-lg shadow-xl font-medium text-white px-2 py-2">
                Bienvenido al registro de vacaciones fuera del programa; para emergencias únicamente y siempre cuando tengas días disponibles
            </label>
                <!-- Mensaje de error -->
                @if (session()->has('message'))
                    <div class="px-2 inline-flex flex-row" id="mssg-status">
                        {{ session()->get('message') }}
                        @if (session()->get('message') == 'Solicitud de vacaciones creada')
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-red-600 h-6 w-6" fill="none"
                                viewBox="pedit0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="width:100%;">
                    <table id="data-table" class="stripe hover"
                        style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                            <tr align="center">
                                <th style=" border-color: rgb(21 128 61);background-color: green;"
                                    class="rounded  hover:bg-green-900 text-white font-bold py-2 px-20">Fecha de Inicio
                                </th>
                                <th style="border-color: rgb(21 128 61);background-color: green;"
                                    class="rounded hover:bg-green-900 text-white font-bold py-2 px-20">Fecha de Termino
                                </th>
                                <th style="border-color: rgb(21 128 61);background-color: green;"
                                    class="flex align-center justify-center rounded  hover:bg-green-900 text-white font-bold py-2 px-2">
                                    Justificación/Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center" class="border px-4 py-2">
                                    <input id="inicio" name="fecha_Inicio" type="date"
                                        style="border-color: rgb(21 128 61);"
                                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                        type="text" required />
                                </td>
                                <td align="center" class="border px-4 py-2">
                                    <input id="fin" name="fecha_Fin" type="date"
                                        style="border-color: rgb(21 128 61);"
                                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                        type="text" required />
                                </td>
                                <td align="center" class="border px-4 py-2">
                                    <input id="justificacion" name="justificacion" style="border-color: rgb(21 128 61);"
                                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                        type="text" value=" " required />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('solicitarfuera.index') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <!-- botón enviar -->

                        <form action="{{ route('solicitars.index') }}" method="POST"
                            class="formEnviar w-auto bg-green-600 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
                            <button onClick="has_errors" type="submit" style="background-color: rgb(21 128 61);"
                                class="w-auto bg-green-600 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Enviar</button>

                        </form>

                    </div>
                </div>
            </div>
        </form>
    </div>
    @section('js')
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js">
        </script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"></script>
        <script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

        {{-- <script src="{{('https://code.jquery.com/jquery-3.5.1.js')}}"></script> --}}
        <script src="{{ 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js' }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js' }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                /* var table_data = $('#data-table').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json'
                        }
                    }); */
                var table_vacations = $('#vacations-table').DataTable({
                    /* dom: 't', */
                    responsive: true,
                    autoWidth: false,
                    "language": {
                        /* "lengthMenu": "Mostrar _MENU_ registros por página",
                        "zeroRecords": "No se encontraron resultados",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay registros disponibles",
                        "infoFiltered": "(filtrado de _MAX_ registros totales)",
                        "search": "Buscar: ",
                        "paginate": {
                            "next": "Siguiente",
                            "previous": "Anterior"
                        } */
                        url: '//cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json'
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>

<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
{{-- <script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script> --}}

<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
        var forms = document.querySelectorAll('.formEnviar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirmar el envio?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Enviado!',
                                'La solicitud ha sido enviado exitosamente.', 'success');
                        } else {
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
                            loader.style.display = "none";
                        }
                    })
                })
            })
    })()
</script>
<script>
    //VALIDAR SI HAY ERRORES EN LOS DATOS Y MOSTRAR CADA ERROR
    var has_errors = {{ $errors->count() > 0 ? 'true' : 'false' }};
    if (has_errors) {
        Swal.fire({
            title: 'Advertencia',
            icon: 'info',
            html: jQuery("#ERROR_COPY").html(),
            showCloseButton: true,
        });
    }
</script>
