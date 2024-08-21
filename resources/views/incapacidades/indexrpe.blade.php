<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(!isset($nombreCompleto))
            {{ __('Incapacidades') }}
            @else
            {{ __('Incapacidades de '.$nombreCompleto) }}
            @endif
        </h2>
    </x-slot>

    @section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">

        <style>
            .fc-event {
                background-color: red !important;
                border-color: red !important;
            }
            .fc-daygrid-event {
                background-color: red !important;
                border-color: red !important;
            }
        </style>
    @endsection
    <x-boton-regresar />
    @if($incapacidades->isEmpty() )
    <div class="alert"  style=" color: #571515; background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
            <p>No hay datos disponibles para mostrar en la tabla.</p>
        </div>
    @endif

    <div class="py-10">
        @if(!isset($RijIncapacidad) || $RijIncapacidad == false)
        @php $mostrarDivision = Auth::user()->hasAnyRole(['admin', 'Doctora']); @endphp
        <div class="grid grid-cols-3 md:grid-cols-{{ $mostrarDivision ? 5 : 4}} gap-5 md:gap-8 mx-7">
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                <select id="_area_filtro" name="area_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @can('controlDivisional')
                        <option value="0" style='color: blue;'>Todas</option>
                        @foreach ($areas as $area)
                            <option @if ($area->area_clave == Auth::user()->datos->getArea->area_clave) selected @endif value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                        @endforeach
                    @else
                        <option value="{{ Auth::user()->datos->getArea->area_clave }}">{{ Auth::user()->datos->getArea->area_nombre}}</option>
                    @endcan
                </select>
            </div>
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Subárea:</label>
                <select id="_subarea_filtro" name="subarea_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                    @foreach ($subareas as $subarea)
                        <option value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Tipo de Incapacidad:</label>
                <select id="_tipo_filtro" name="tipo_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                    <option value="Inicial">Inicial</option>
                    <option value="Subsecuente">Subsecuente</option>
                </select>
            </div>

            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Ramo de seguro:</label>
                <select id="_ramo_filtro" name="ramo_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                    <option value="General">General</option>
                    <option value="Riesgo de trabajo">Riesgo de trabajo</option>
                    <option value="Maternidad">Maternidad</option>
                </select>
            </div>

            <div class="flex justify-center gap-4 col-span-5">
                <div class="grid">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha de inicio:</label>
                    <input  id="_fecha_inicio_filtro" name="fecha_inicio_filtro" type="date" {{--min="{{date('Y-m-d');}}"--}} class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"  required/>
                </div>
                <div class="grid">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha de fin:</label>
                    <input  id="_fecha_fin_filtro" name="fecha_fin_filtro" type="date" {{--min="{{date('Y-m-d');}}"--}} class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"  required/>
                </div>
            </div>

        </div>
        <br>
        <div class="grid grid-cols-3 md:grid-cols-5 gap-5 md:gap-8 mx-7">
            <div class="grid grid-col-1 ">
                <h3 class="py-2 px-3 mx-2 ml-2">Total de Registros:<span id="total_de_registros"><strong>{{$totalRegistros}}</strong></span></h3>
            </div>
            <div class="grid grid-cols-1"></div>
            <div class="grid grid-col-1 place-items-center mt-3">
                <!-- botón Filtrar -->
                @if (\Session::has('success'))
                    <div id="success-message" class="alert alert-success opacity-100 transition-opacity duration-500">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif
                    <!-- ---------------------------------------------------------------------------------------------->
                <button onClick="filter()" style="text-decoration:none;"
                class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
                    <!-- ---------------------------------------------------------------------------------------------->
            </div>

            <div class="grid grid-cols-1"></div>
                    <div class="grid grid-cols-1">
                        <h3>Dias de incapacidad:<span id="total_dias_autorizados"><strong>{{$dias_autorizados ?? 0}}</strong></span></h3>
                    </div>
            </div>
        @endif
        <div class="mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="px-2 inline-flex flex-row" id="mssg-status">
                    {{ session()->get('message') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 border-4 p-4"
                style="width:95%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto">
                <button class="rounded bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-3 self-end"
                    onclick="mostrarModal();">Visualizar en calendario</button>
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>ZONA</th>
                            <th>SUBAREA</th>
                            <th>TIPO</th>
                            {{-- <th>RPE</th> --}}
                            <th>RAMO DE SEGURO</th>
                            <th>DÍAS AUTORIZADOS</th>
                            <th>DÍAS ACUMULADOS</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FIN</th>
                            <th>USUARIO</th>
                            <th>PADECIMIENTO</th>
                            @if(auth()->user()->can('incapacidad.autorizar'))
                                <th>Estatus</th>
                            @endif
                            <th class="none">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($incapacidades as $incapacidad)
                        <tr>
                            <td>{{$incapacidad->sub->area->area_nombre}}</td>
                            <td>{{$incapacidad->sub->subarea_nombre}}</td>
                            <td>{{$incapacidad->tipo}}</td>
                            {{-- <td>{{$incapacidad->rpe}}</td> --}}
                            <td>{{$incapacidad->ramo_de_seguro}}</td>
                            <td>{{$incapacidad->dias_autorizados}}</td>
                            <td
                            @if ($incapacidad->dias_acumulados >= 30) style="color: red" @endif>
                                {{$incapacidad->dias_acumulados}}
                            </td>
                            <td>{{$incapacidad->fecha_inicio}}</td>
                            <td>{{$incapacidad->fecha_fin}}</td>
                            <td>{{$incapacidad->user->nombre}} {{$incapacidad->user->paterno}} {{$incapacidad->user->materno}}</td>
                            <td>{{$incapacidad->padecimientos->padecimiento_nombre}}</td>
                            @if( auth()->user()->can('incapacidad.autorizar') )
                            <td>{{$incapacidad->estatus}}</td>
                            @endif
                            <td>
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <!-- Mostrar/Visualizar incapacidad -->
                                    <a href="{{ route('incapacidades.show', $incapacidad->id) }}" style="text-decoration: none" class="rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 ml-2" >Ver</a>
                                    @can('incapacidad.edit')
                                    <!-- Editar incapacidad -->
                                    <a href="{{ route('incapacidades.edit', $incapacidad->id) }}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 ml-2" >Editar</a>
                                    @endcan
                                    @can('incapacidad.autorizar')
                                        @if($incapacidad->estatus == 'Pendiente')
                                            <!-- Autorizar incapacidad -->
                                            <a href="{{ route('incapacidades.autorizar', $incapacidad->id) }}" style="text-decoration: none" class="rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 ml-2" >Autorizar</a>
                                            <!-- Rechazar incapacidad -->
                                            <a href="{{ route('incapacidades.rechazar', $incapacidad->id) }}" style="text-decoration: none" class="rounded-lg bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 ml-2" >Rechazar</a>
                                        @endif
                                    @endcan
                                    @can('incapacidad.delete')
                                    <!-- Eliminar incapacidad -->
                                    <form id="formEliminar-{{ $incapacidad->id }}" action="{{ route('incapacidades.destroy', $incapacidad->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $incapacidad->id }});" style="text-decoration: none" class="rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 ml-2">Eliminar</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @can('incapacidad.create')
                    <div class="flex items-center justify-center  md:gap-8 gap-4 pb-5" style="display:flex; gap:10px;">
                        <a type="button" href="{{ route('datos.index') }}" style="text-decoration:none"
                            class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                        <!-- botón crear -->
                    <a type="button" href="{{ route('incapacidades.create', ['rpe' => $rpe]) }}" style="text-decoration: none" class="rounded-lg bg-blue-600 hover:bg-blue-500 text-white hover:text-gray-700 font-bold py-2 px-4 ml-2" style="text-decoration:none"
                        >Crear</a>
                    </div>
                @endcan
            </div>
        </div>

        {{-- Modal --}}
        <div id="myModal" class="fixed flex inset-0 z-50 bg-black bg-opacity-50 justify-center items-center">
            <div class="bg-white rounded-lg p-6 max-w-md lg:max-w-7xl w-full">
                <h2 class="text-xl font-bold mb-3">Calendario de incapacidades</h2>
                <div class="w-full h-96 overflow-hidden bg-gray-200 p-4 shadow-lg rounded-lg">
                    <div id="calendar" class="w-full h-full"></div>
                </div>
                <div class="mt-4 flex justify-center gap-4">
                    <button onclick="cerrarModal();" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <link rel="stylesheet" href={{asset('plugins/fullcalendar/fullcalendar.min.css')}} /> --}}

    @section('js')
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script> --}}
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"></script>
    <script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

    {{-- <script src="{{('https://code.jquery.com/jquery-3.5.1.js')}}"></script> --}}
    <script src="{{('https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js')}}"></script>
    <script src="{{ asset('js/customDataTables.js') }}"></script>
        {{-- script para calendario --}}
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/locale/es.js'></script>
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
<script>
    // Función para ocultar los mensajes
    function hideMessage(element) {
            if (element) {
                // Esperar 5 segundos antes de ocultar el mensaje
                setTimeout(() => {
                    element.classList.add('opacity-0'); // Cambiar la opacidad a 0
                    setTimeout(() => {
                        element.style.display = 'none'; // Ocultar el elemento después de la transición
                    }, 500); // Tiempo de la transición (500ms)
                }, 5000); // Esperar 5 segundos
            }
        }
    document.addEventListener('DOMContentLoaded', (event) => {
        // Seleccionar el elemento del mensaje de éxito
        var successMessage = document.getElementById('success-message');
        var noDataMessage = document.getElementById('no-data-message');

        hideMessage(successMessage);
        hideMessage(noDataMessage);
    });
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";

    function filter() {
        var f_area = document.getElementById("_area_filtro").value;
        var f_subarea = document.getElementById("_subarea_filtro").value;
        var f_tipo = document.getElementById("_tipo_filtro").value;
        var f_ramo = document.getElementById("_ramo_filtro").value;
        var padecimiento = document.getElementById('padecimiento') ?
        document.getElementById('padecimiento').value : '0';
        var f_dias = document.getElementById("_fecha_inicio_filtro").value;
        var f_diasFin = document.getElementById("_fecha_fin_filtro").value;
        var f_estatus = '0';
        if(document.getElementById("_estatus_filtro")){
            f_estatus = document.getElementById("_estatus_filtro").value;
        }
        var table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtrarIncapacidades', {
            method: 'POST',
            body: JSON.stringify({
                division: 'DX',
                area: f_area,
                subarea: f_subarea,
                tipo: f_tipo,
                ramo: f_ramo,
                padecimiento: padecimiento,
                fecha: f_dias,
                fechaf: f_diasFin,
                estatus: f_estatus,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            if (!response.ok) {
                console.log(response)
                throw new Error('error');

            } else
                return response.json()

        }).then(data => {
            if (data.incapacidades.length === 0 ) {

                var noDataMessage = document.getElementById('no-data-message');
                setTimeout(() => {
                    noDataMessage.style.display = 'block'; // Asegúrate de que el elemento esté visible
                    noDataMessage.classList.remove('opacity-0'); // Remover la clase que oculta el mensaje
                    noDataMessage.classList.add('opacity-100'); // Agregar la clase para mostrar el mensaje
                }, 500);
                hideMessage(noDataMessage);

            }
            //console.log(data);
            document.getElementById('total_dias_autorizados').innerText = data.total_dias_autorizados;
            document.getElementById('total_de_registros').innerText = data.total_registros;
            table.clear();
            //console.log(data.lista)
            var div_Init = "<td>";
            var div_End = "</td>";
            var tipo = "";
            var subarea = "";
            // var rpe = "";
            var padecimiento = "";
            var ramo_de_seguro = "";
            var dias_autorizados = "";
            var dias_acumulados = "";
            var fecha_inicio = "";
            var fecha_fin = "";
            var usuario = "";
            var acciones = "";
            var area = "";
            //console.log(data);
            for (let i in data.incapacidades) {
                area = div_Init + data.incapacidades[i].sub.area.area_nombre + div_End;
                subarea = div_Init + data.incapacidades[i].sub.subarea_nombre + div_End;
                tipo = div_Init + data.incapacidades[i].tipo + div_End;
                // rpe = div_Init + data.incapacidades[i].rpe + div_End;
                ramo_de_seguro = div_Init + data.incapacidades[i].ramo_de_seguro + div_End;
                dias_autorizados = div_Init + data.incapacidades[i].dias_autorizados + div_End;
                if(data.incapacidades[i].dias_acumulados >= 30){
                    dias_acumulados = div_Init + '<div style="color: red">'+ data.incapacidades[i].dias_acumulados + div_End;
                }
                else{
                    dias_acumulados = div_Init + data.incapacidades[i].dias_acumulados + div_End;
                }
                fecha_inicio = div_Init + data.incapacidades[i].fecha_inicio + div_End;
                fecha_fin = div_Init + data.incapacidades[i].fecha_fin + div_End;
                usuario = div_Init + data.incapacidades[i].user.nombre + " " + data.incapacidades[i].user.paterno + " " + data.incapacidades[i].user.materno + div_End;
                padecimiento = div_Init + data.incapacidades[i].padecimientos.padecimiento_nombre + div_End;
                acciones = div_Init + '<div class="flex justify-center rounded-lg text-lg" role="group">';

                const verIncapacidad_URL = '{{ route('incapacidades.show', ':id') }}'.replace(':id', data.incapacidades[i].id);
                acciones += `<a href="${verIncapacidad_URL}" style="text-decoration: none" class="rounded-lg bg-green-500 hover:bg-green-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Ver</a>`;

                @can('incapacidad.edit')
                    const editarIncapacidad_URL = '{{ route('incapacidades.edit', ':id') }}'.replace(':id', data.incapacidades[i].id);
                    acciones += `<a href="${editarIncapacidad_URL}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Editar</a>`;
                @endcan
                @can('incapacidad.delete')
                    const elimimarIncapacidad_URL = '{{ route('incapacidades.destroy', ':id') }}'.replace(':id', data.incapacidades[i].id);
                    acciones += `<form id="formEliminar-${data.incapacidades[i].id}" action="${elimimarIncapacidad_URL}" method="POST" class="inline-block"> @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(${data.incapacidades[i].id});" style="text-decoration: none" class="rounded-lg bg-red-600 hover:bg-red-700 text-black hover:text-white font-bold py-2 px-4 ml-2">Eliminar</button>
                                </form>`;
                @endcan

                @can('incapacidad.autorizar')
                    if(data.incapacidades[i].estatus == 'Pendiente'){

                        const autorizarIncapacidad_URL = '{{ route('incapacidades.autorizar', ':id') }}'.replace(':id', data.incapacidades[i].id);
                        acciones += `<a href="${autorizarIncapacidad_URL}" style="text-decoration: none" class="rounded-lg bg-blue-500 hover:bg-blue-600 text-black hover:text-white font-semibold py-2 px-4 ml-2">Autorizar</a>`;
                        const rechazarIncapacidad_URL = '{{ route('incapacidades.rechazar', ':id') }}'.replace(':id', data.incapacidades[i].id);
                        acciones += `<a href="${rechazarIncapacidad_URL}" style="text-decoration: none" class="rounded-lg bg-red-600 hover:bg-red-700 text-black hover:text-white font-semibold py-2 px-4 ml-2">Rechazar</a>`;
                    }
                @endcan
                acciones += '</div>' + div_End;
                if (data.incapacidadAutorizar) {
                    estatus = div_Init + data.incapacidades[i].estatus + div_End;
                    table.row.add([
                    area,
                    subarea,
                    tipo,
                    // rpe,
                    ramo_de_seguro,
                    dias_autorizados,
                    dias_acumulados,
                    fecha_inicio,
                    fecha_fin,
                    usuario,
                    padecimiento,
                    estatus,
                    acciones
                ]);
                }else{
                    table.row.add([
                    area,
                    subarea,
                    tipo,
                    // rpe,
                    ramo_de_seguro,
                    dias_autorizados,
                    dias_acumulados,
                    fecha_inicio,
                    fecha_fin,
                    usuario,
                    padecimiento,
                    acciones
                ]);
                }
            }

            table.draw();
        });


    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const datosCalendario = @json($incapacidadesJson);

        if (Array.isArray(datosCalendario)) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'multiMonthYear',
                locale: 'es',
                events: datosCalendario,
                views: {
                    multiMonthFourMonth: {
                        type: 'multiMonth',
                        duration: { months: 2 }
                    }
                },
                datesSet: function(info) {
                    var today = moment();
                    var startOfMonth = moment(info.start);
                    var endOfMonth = moment(info.end);

                    if (today.isBetween(startOfMonth, endOfMonth, null, '[]')) {
                        var todayCell = calendarEl.querySelector('.fc-day-today');
                        if (todayCell) {
                            todayCell.style.backgroundColor = 'transparent';
                        }
                    }
                }
            });

            calendar.render();
        } else {
            console.error("Los datos no son un array.");
        }

        // Inicialmente se deja el modal "abierto" (flex) para evitar bug con estilos de fullCalendar
        cerrarModal();
    });
</script>

<script>
    //Actualizar subareas select dependiendo el area
    document.getElementById('_area_filtro').addEventListener('change', (e) => {
        fetch(SITEURL + '/subareas', {
            method: 'POST',
            body: JSON.stringify({
                area: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "<option value='0' style='color: blue;'>Todas</option>";
            for (let i in data.lsubarea) {
                opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("_subarea_filtro").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>

{{-- Scripts modal --}}
<script>
    const modal = document.getElementById('myModal');

    function mostrarModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
