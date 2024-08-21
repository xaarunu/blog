<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Antecedentes') }}
        </h2>
    </x-slot>
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection
    <div class="py-10">
        <x-boton-regresar />
        <div class="col-sm-12">
            @if($mensaje = Session::get('success'))
                <div class="alert alert-success" role="alert">
                {{ $mensaje }}
                </div>
            @endif
        </div>
        <div class="alert" id="elementoOculto" style=" display: none; color: #571515; background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
            <p>No hay datos disponibles para mostrar en la tabla.</p>
        </div>
        <div class="w-full flex justify-center items-center ">
            <div class="text-center p-4">
                <div class="flex flex-row mb-3">
                    @php $mostrarDivision = Auth::user()->hasAnyRole(['admin', 'Doctora']); @endphp
                    <div class="mr-4 @if(!$mostrarDivision) hidden @endif">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">División:</label>
                        <select id="divisionFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @if($mostrarDivision)
                                @foreach ($divisiones as $division)
                                    <option @if($division->division_clave == Auth::user()->datos->getDivision->division_clave) selected @endif value="{{ $division->division_clave }}">{{ $division->division_nombre }}</option>
                                @endforeach
                            @else
                                <option selected value="{{ Auth::user()->datos->getDivision->division_clave }}"></option>
                            @endif
                        </select>
                    </div>
                    <div class="mr-4" >
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Área:</label>
                        <select id="areaFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @can('controlDivisional')
                                <option value="all">Todas las áreas</option>
                                @foreach ($areas as $area)
                                    <option @if ($area->area_clave == Auth::user()->datos->getArea->area_clave) selected @endif value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                @endforeach
                            @else
                                <option value="{{ Auth::user()->datos->getArea->area_clave }}">{{ Auth::user()->datos->getArea->area_nombre}}</option>
                            @endcan
                        </select>
                    </div>
                    {{-- Filtro de sub areas, se esta ocultando por que no hay sub areas disponibles o asignadas a los vehiculos de momento.  --}}
                    <div  class="mr-4">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Subárea:</label>
                        <select id="subareaFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all">Todas las subáreas</option>
                            @foreach($subareas as $subarea)
                                @if (strpos($subarea->area->area_clave, 'DX') === 0)
                                    <option value="{{ $subarea->subarea_clave }}"
                                        data-area="{{ $subarea->area_id }}">{{ $subarea->subarea_nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div  class="mr-4">
                        <label for="filtro_dia_inicio" class="block uppercase md:text-sm text-xs text-gray-500 font-semibold ">Fecha Inicio</label>
                        <input id="filtro_dia_inicio" name="filtro_dia_inicio" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date" value="{{now()->format('Y-m-d')}}" />
                    </div>

                    <div  class="mr-4" >
                        <label for="filtro_dia_fin" class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin</label>
                        <input id="filtro_dia_fin" name="filtro_dia_fin" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date" value="{{now()->format('Y-m-d')}}" />
                    </div>
                    <br>
                    <div class="grid grid-rows-1 place-items-center mt-3">
                        <!-- botón Filtrar -->
                            <!-- ---------------------------------------------------------------------------------------------->
                        <button onClick="filter()" style="text-decoration:none;"
                        class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
                            <!-- ---------------------------------------------------------------------------------------------->
                    </div>
                    <br>

                </div>
            </div>
        </div>

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th align="center">Id</th>
                            <th align="center">RPE</th>
                            <th align="center">Nombre</th>
                            <th align="center">Fecha de creación</th>
                            <th align="center">Área</th>
                            <th align="center">Subárea</th>
                            <th class="none">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antecedentes as $antecedente)
                        <tr>
                            <td align="center">{{ $antecedente->id }}</td>
                            <td align="center">{{ $antecedente->rpe }}</td>
                            <td align="center">{{ $antecedente?->user->nombre.' '.$antecedente?->user->paterno.' '.$antecedente?->user->materno }}</td>
                            <td align="center">{{ $antecedente?->created_at->format('Y-m-d') }}</td>
                            <td align="center">{{ $antecedente?->user->getArea->area_nombre }}</td>
                            <td align="center">{{ $antecedente?->user->getSubarea->subarea_nombre}}</td>
                            <td class="none">
                                <div class="flex justify-center rounded-lg text-lg" role="group" style="display:flex; gap:10px;">
                                    <!-- Botón Ver -->
                                    <a style="text-decoration: none" href="{{ route('personales.edit', $antecedente->rpe) }}"
                                        class="rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 mx-auto">Ver
                                    </a>
                                    @can('antecedente.delete')
                                    <!-- Botón Borrar -->
                                    <form id="formEliminar-{{ $antecedente->id }}" action="{{ route('personales.destroy', [$antecedente->id, $antecedente->rpe]) }}" method="POST"
                                        class="rounded-lg bg-red-600 hover:bg-red-700 mx-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $antecedente->id }});" class="rounded-lg text-black font-bold py-2 px-4 mx-auto">
                                            Borrar
                                        </button>
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
                    <a type="button" href="{{ route('datos.index') }}" style="text-decoration:none"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <!-- botón crear -->
                    <a type="button" href="{{ route('personales.create', ['rpe'=>0]) }}" style="text-decoration:none"
                        class="rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4">Crear</a>
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
{{-- Script de filtros --}}
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
    function filter() {
        var division = document.getElementById('divisionFilter').value;
        var areaFilter = document.getElementById('areaFilter').value;
        var subareaFilter = document.getElementById('subareaFilter').value;
        const fecha_inicio = document.getElementById('filtro_dia_inicio').value;
        const fecha_fin = document.getElementById('filtro_dia_fin').value;
        fetch(SITEURL + '/personales/filtro/show_allAntecedentes',{
            method: 'POST',
            body: JSON.stringify({
                division: division,
                area: areaFilter,
                subarea: subareaFilter,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            if (!response.ok) {
                throw new Error('error');
            } else
                return response.json()
        }).then(data => {
            // Obtén la referencia de la tabla
            var dataTable = $('#data-table').DataTable();
             // Limpiar la tabla antes de agregar nuevos datos
             dataTable.clear();
            if (data.antecedentes.length === 0 ) {
                elementoOculto.style.display = "block"; // Mostrar el mensaje
                setTimeout(function () {
                    elementoOculto.style.display = "none"; // Ocultar el mensaje después de 3 segundos
                }, 3000);
            }
            // Agregar nuevos datos a la tabla
            data.antecedentes.forEach(antecedentes => {
                var urlUsar = `{{route('personales.edit','id')}}`;
                    urlUsar = urlUsar.replace('id',antecedentes.id);
                var urlUsar2 = `{{route('personales.destroy',['id','rpe'])}}`;
                    urlUsar2 = urlUsar2.replace('id',antecedentes.id,'rpe',antecedentes.rpe);
                var optionsBtns = `<div class="flex justify-center rounded-lg text-lg" role="group" style="display:flex; gap:10px;">
                    <!-- Botón Ver -->
                    <a style="text-decoration: none" href="` + urlUsar + `"
                        class="rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 mx-auto">Ver
                    </a>`;
                    @can('antecedente.delete')
                    optionBtns += `<!-- Botón Borrar -->
                    <form id="formEliminar-${antecedentes.id}" action="` + urlUsar2 + `" method="POST"
                        class=" rounded-lg bg-red-600 hover:bg-red-700 mx-auto">
                        @csrf
                        @method('DELETE')
                        <button type="button" onClick="confirmDelete(${antecedentes.id});" class="rounded-lg text-black font-bold py-2 px-4 mx-auto">
                            Borrar
                        </button>
                    </form></div>`;
                    @endcan
                // Convertir la cadena de fecha a un objeto Date
                const fechaCreacion = new Date(antecedentes.created_at);
                // Formatear la fecha como 'YYYY-MM-DD'
                const fechaFormateada = fechaCreacion.toISOString().split('T')[0];
                dataTable.row.add([
                    antecedentes.id,
                    antecedentes.rpe,
                    antecedentes.user.nombre + ' ' + antecedentes.user.paterno + ' ' + antecedentes.user.materno,
                    fechaFormateada,
                    antecedentes.user.get_area.area_nombre,
                    antecedentes.user.get_subarea.subarea_nombre,
                    optionsBtns
                ]);
            });
            // Dibujar la tabla
            dataTable.draw();
            // Centrar elementos en la tabla después de dibujar
            $(document).ready(function() {
                // Aplicar clases de estilo para centrar
                $('#data-table').addClass('text-center').addClass('align-middle');
            });
        });
    }
</script>
<script>
    //Actualizar areas select dependiendo de la división
    document.getElementById('divisionFilter').addEventListener('change', (e) => {
        fetch(SITEURL + '/areas', {
            method: 'POST',
            body: JSON.stringify({
                division: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            let opciones = "<option value='all'>Todas las áreas</option>";
            for (let i in data.lareas) {
                opciones += '<option value="' + data.lareas[i].area_clave + '">' + data.lareas[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("areaFilter").innerHTML = opciones;

            fetch(SITEURL + '/subareas', {
                method: 'POST',
                body: JSON.stringify({
                    area: data.lareas[0].area_clave,
                    "_token": "{{ csrf_token() }}"
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                },
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "<option value='all'>Todas las subáreas</option>";
                for (let i in data.lsubarea) {
                    opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data
                        .lsubarea[i].subarea_nombre + '</option>';
                }
                document.getElementById("subareaFilter").innerHTML = opciones;
            }).catch(error => alert(error));

        }).catch(error => alert(error));
    })
</script>
<script>
    //Actualizar subareas select dependiendo el area
    document.getElementById('areaFilter').addEventListener('change', (e) => {
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
            var opciones = "<option value='all'>Todas las subáreas</option>";
            for (let i in data.lsubarea) {
                opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("subareaFilter").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
