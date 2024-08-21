<x-app-layout>
    @section('title', 'DCJ - CFE: Entrega de recepción')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entrega de Recepción') }}
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
            <div class="alert-{{ session('message_type') ?? 'dark' }} w-80 md:w-1/2 mx-auto py-8 px-4 mb-4" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <x-boton-regresar />

        {{-- Filtro --}}
        <div class="w-10/12 mx-auto flex flex-col md:flex-row my-11 gap-4">
            <!-- División -->
            @php $mostrarDivision = Auth::user()->hasAnyRole(['admin', 'Doctora']); @endphp
            <div class="flex-grow grid grid-cols-1 @if(!$mostrarDivision) hidden @endif">
                <label class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">División:</label>
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
            <!-- Área -->
            <div class="flex-grow grid grid-cols-1">
                <label class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Área:</label>
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
            <!-- Subárea -->
            <div class="flex-grow grid grid-cols-1">
                <label class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Subárea:</label>
                <select id="subareaFilter"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="all">Todas las subáreas</option>
                    @foreach($subareas as $subarea)
                        <option value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Filtro para Fechas -->
            <div class="flex-grow grid grid-cols-1">
                <label for="filtro_dia_inicio" class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold ">Fecha Inicio</label>
                <input id="filtro_dia_inicio" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date"/>
            </div>
            <div class="flex-grow grid grid-cols-1">
                <label for="filtro_dia_fin" class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin</label>
                <input id="filtro_dia_fin" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date"/>
            </div>
            <!-- Botón -->
            <div class="flex-grow self-end mx-auto md:self-center">
                <button onClick="filter()" style="text-decoration:none;"
                class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3">Filtrar</button>
            </div>
        </div>

        <div class="mx-auto sm:px-6 lg:px-8 w-11/12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                {{-- Tabla de datos --}}
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>Entrega</th>
                            <th>Recibe</th>
                            <th>Fecha de incio</th>
                            <th>Fecha final</th>
                            <th>Roles</th>
                            <th class="none">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $entrega)
                            <tr>
                                <td>{{ $entrega->usuarioAusente->getNombreCompleto() }}</td>
                                <td>{{ $entrega->usuarioReceptor->getNombreCompleto() }}</td>
                                <td>{{ $entrega->fecha_inicio }}</td>
                                <td>{{ $entrega->fecha_final }}</td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach ($entrega->rolesPrestados as $rol)
                                            <li>{{ $rol->info->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        <a href="{{ route('recepcion.show', $entrega->id) }}" style="text-decoration: none" class="rounded-lg bg-green-500 hover:bg-green-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Ver</a>
                                        @can('recepcion.edit')
                                        <a href="{{ route('recepcion.edit', $entrega->id) }}" style="text-decoration: none"
                                            class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2">Editar</a>
                                        @endcan
                                        @can('recepcion.delete')
                                        <form id="formEliminar-{{ $entrega->id }}" action="{{ route('recepcion.destroy', $entrega->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="confirmDelete({{ $entrega->id }})" type="button" style="text-decoration: none"
                                                class="rounded-lg bg-red-600 hover:bg-red-700 text-black hover:text-white font-bold py-2 px-4 ml-2">Eliminar</button>
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
                    @can('recepcion.create')
                    <a type="button" href="{{ route('recepcion.create') }}" style="text-decoration:none"
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
{{-- Scrip de filtros --}}
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const SITEURL = "{{ url('/') }}";

    function filter() {
        const table = $('#data-table').DataTable();

        fetch(SITEURL + '/recepciones/filtro',{
            method: 'POST',
            body: JSON.stringify({
                division: document.getElementById('divisionFilter').value,
                area: document.getElementById('areaFilter').value,
                subarea: document.getElementById('subareaFilter').value,
                fechaInicial: document.getElementById('filtro_dia_inicio').value,
                fechaFinal: document.getElementById('filtro_dia_fin').value,
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
            table.clear();

            const div_Init = "<td class='px-6 py-4 text-center'>";
            const div_End = "</td>";

            let entrega = "";
            let recibe = "";
            let fecha_inicio = "";
            let fecha_final = "";
            let roles = "";
            let acciones = "";

            const infoRoles = data.infoRoles;

            if(data.entregas && data.entregas.length > 0) {
                data.entregas.forEach(res => {
                    // Datos calculados
                    const nombreCompletoAusente = [res.usuario_ausente.nombre, res.usuario_ausente.paterno, res.usuario_ausente.materno].join(' ');
                    const nombreCompletoReceptor = [res.usuario_receptor.nombre, res.usuario_receptor.paterno, res.usuario_receptor.materno].join(' ');
                    // Obtener nombres de roles "prestados"
                    const rolesInvolucrados = `<ul class="mb-0">
                                                    ${res.roles_prestados.map(rp => `<li>${infoRoles.find(rol => rol.id == rp.id_rol).name}</li>`)}
                                                </ul>`;

                    // Campos
                    entrega = `${div_Init} ${nombreCompletoAusente} ${div_End}`;
                    recibe = `${div_Init} ${nombreCompletoReceptor} ${div_End}`;
                    fecha_inicio = `${div_Init} ${res.fecha_inicio} ${div_End}`;
                    fecha_final = `${div_Init} ${res.fecha_final} ${div_End}`;
                    roles = `${div_Init} ${rolesInvolucrados} ${div_End}`;
                    acciones = '<div class="flex justify-center rounded-lg text-lg" role="group">';

                    const showEntregaRecepcion_URL = '{{ route('recepcion.show', ':id') }}'.replace(':id', res.id);
                    acciones += `<a href="${showEntregaRecepcion_URL}" style="text-decoration: none" class="rounded-lg bg-green-500 hover:bg-green-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Ver</a>`;

                    @can('recepcion.edit')
                        const editarEntregaRecepcion_URL = '{{ route('recepcion.edit', ':id') }}'.replace(':id', res.id);
                        acciones += `<a href="${editarEntregaRecepcion_URL}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Editar</a>`;
                    @endcan
                    @can('recepcion.delete')
                        const elimimarEntregaRecepcion_URL = '{{ route('recepcion.destroy', ':id') }}'.replace(':id', res.id);
                        acciones += `<form id="formEliminar-${res.id}" action="${elimimarEntregaRecepcion_URL}" method="POST" class="inline-block"> @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(${res.id})" style="text-decoration: none" class="formEliminar rounded-lg bg-red-600 hover:bg-red-700 text-black hover:text-white font-bold py-2 px-4 ml-2">Eliminar</button>
                                    </form>`;
                    @endcan
                    acciones += div_End;

                    table.row.add([
                        entrega,
                        recibe,
                        fecha_inicio,
                        fecha_final,
                        roles,
                        acciones
                    ]);
                })
            }
            table.draw();
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
            let opciones = "<option value='all' style='color: blue;'>Todas las áreas</option>";
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
                var opciones = "<option value='all' style='color: blue;'>Todas las subáreas</option>";
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
            var opciones = "<option value='all' style='color: blue;'>Todas las subáreas</option>";
            for (let i in data.lsubarea) {
                opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("subareaFilter").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
