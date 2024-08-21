<x-app-layout>
    @section('title', 'DCJ - CFE: Prestación de lentes')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestación de lentes') }}
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

        {{-- Filtro --}}
        <div class="flex flex-col md:flex-row items-center justify-center my-4 gap-4 text-left md:text-center">
            {{-- ÁREA --}}
            <div class="w-2/3 md:w-auto">
                <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                <select id="_area_filtro"
                    class="min-w-40 w-full py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @can('controlDivisional')
                        <option value="all" style="color: blue;">Todas las áreas</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->area_clave }}" @if ($area->area_clave == Auth::user()->datos->area) selected @endif>
                                {{ $area->area_nombre }}
                            </option>
                        @endforeach
                    @else
                        <option selected value="{{ Auth::user()->datos->area }}">{{ Auth::user()->datos->getArea->area_nombre}}</option>
                    @endcan
                </select>
            </div>
            {{-- SUBÁREA --}}
            <div class="w-2/3 md:w-auto">
                <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Subárea:</label>
                <select id="_subarea_filtro"
                    class="min-w-40 w-full py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="all" style="color: blue;">Todas las subáreas</option>
                    @foreach($subareas as $subarea)
                        <option value="{{ $subarea->subarea_clave }}" @if ($subarea->subarea_clave == Auth::user()->datos->subarea) selected @endif>
                            {{ $subarea->subarea_nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- FECHAS --}}
            <div class="w-2/3 md:w-auto">
                <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Inicio</label>
                <input id="filtro_dia_inicio" class="w-full py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date"/>
            </div>
            <div class="w-2/3 md:w-auto">
                <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin</label>
                <input id="filtro_dia_fin" class="w-full py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date"/>
            </div>
            {{-- BOTÓN --}}
            <div class=" mt-3">
                <button id="filterBtn" type="button" class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3">Filtrar</button>
            </div>
        </div>

        {{-- Flash msg --}}
        @if (Session::has('message') || $errors->any())
            <div class="alert-{{ session('message_type') ?? 'error' }} border rounded-lg w-80 md:w-1/2 mx-auto py-8 px-4 my-4" role="alert">
                @if(Session::has('message')) {{ session('message') }} @endif
                @if($errors->any())
                    <h5 class="text-lg">Datos erroneos, verifica la información ingresada</h5>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li class="list-item pl-4">* {{ $error }}</li>
                        @endforeach
                    </ol>
                @endif
            </div>
        @endif
        
        {{-- Tabla --}}
        <div class="mx-auto sm:px-6 lg:px-8 w-11/12 md:w-9/12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 w-full">
                <table id="data-table" class="stripe hover translate-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>RPE</th>
                            <th>Nombre</th>
                            <th>Ultima solicitud</th>
                            <th class="none">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                @php
                                    $ultimaFechaActiva = date('Y-m-d', strtotime('-365 days'));
                                    $ultimaPrestacion = $usuario?->lentes ?? null;
                                    // Posibles "estatus": *Sin registros previos, *Registro vencido, *Registro activo
                                    $estatus = '';

                                    if($ultimaPrestacion)
                                        $estatus = ($ultimaPrestacion->fecha_asignacion >= $ultimaFechaActiva) ? 'prestacion-activa' : 'prestacion-inactiva';
                                @endphp
                                <td>{{ $usuario->rpe }}</td>
                                <td>{{ $usuario->getNombreCompleto() }}</td>
                                <td class="{{ $estatus }}">{{ $ultimaPrestacion ? $ultimaPrestacion->fecha_asignacion : 'Sin solicitudes' }}</td>
                                <td>
                                    <div class="flex justify-center items-center rounded-lg gap-2 empty:hidden" role="group">
                                        @if ($estatus != 'prestacion-activa')
                                            <button class="py-2 px-4 rounded-lg text-white font-bold bg-green-500 hover:bg-green-600"
                                            onclick="openModal('{{ $usuario->rpe }}');">Generar Solicitud</button>
                                        @else
                                            <!-- Botones relacionados a la ultima solicitud -->
                                            <a class="py-2 px-4 rounded-lg text-white font-bold bg-blue-500 hover:bg-blue-600"
                                                href="{{ route('lentes.show', $ultimaPrestacion->id) }}">Ver</a>
                                            @can('prestacion.edit')
                                                <a class="py-2 px-4 rounded-lg text-white font-bold bg-yellow-600 hover:bg-yellow-700"
                                                    href="{{ route('lentes.edit', $ultimaPrestacion->id) }}">Editar</a>
                                            @endcan
                                            @can('prestacion.delete')
                                                <form id="formEliminar-{{ $ultimaPrestacion->id }}" method="POST" action="{{ route('lentes.destroy', $ultimaPrestacion->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $ultimaPrestacion->id }});" class="py-2 px-4 rounded-lg text-white font-bold bg-red-500 hover:bg-red-600">Eliminar</button>
                                                </form>
                                            @endcan
                                        @endif

                                        <!-- Si cuenta con al menos un registro, mostrar botón para llevar al historial de registros del usuario -->
                                        @if ($estatus != '')
                                            <a class="py-2 px-4 rounded-lg text-white font-bold bg-cyan-500 hover:bg-cyan-600"
                                            href="{{ route('lentes.historico', $usuario->rpe) }}">Historial</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex items-center justify-center md:gap-8 gap-4 py-5" style="display:flex; gap:10px;">
                    <!-- botón volver -->
                    <a type="button" href="{{ url()->previous() }}" style="text-decoration:none"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <!-- botón crear -->
                    @can('prestacion.create')
                    <a type="button" href="{{ route('lentes.create') }}" style="text-decoration:none"
                        class="rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4">Crear</a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="fixed hidden inset-0 z-50 bg-black bg-opacity-50 justify-center items-center">
            <div class="bg-white rounded-lg p-6 max-w-lg w-full">
                <h2 class="text-xl font-bold mb-3">Registro de prestación</h2>
                <x-lentes-form modal/>
                <div class="mt-4 flex justify-center gap-4">
                    <button onclick="cerrarModal();" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Cerrar</button>
                    <button type="submit" form="formEnviar" class="px-4 py-2 bg-green-600 hover:bg-green-700  text-white rounded">Registrar</button>
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
    // Al cargar todo el documento
    $(document).ready(function() {
        // Desactivar ordenamiento de dataTable para utilizar el dado por el controlador
        $('#data-table').DataTable({
            "responsive": true,
            "order": [],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/a5734b29083/i18n/Spanish.json"
            },
            "bDestroy": true
        });

        // Ocultar alerta automáticamente
        $('[role="alert"]').delay(3500).slideUp(300);
    });
</script>

<script>
    // Funcionamiento del modal
    const modal = document.getElementById('myModal');
    const rpeInput = document.getElementById('rpe');
    const closeModalButton = document.getElementById('closeModal');

    // Ajustes iniciales para el input rpe
    rpeInput.setAttribute('readonly', true);
    rpeInput.classList.add('bg-gray-200');

    function openModal(rpe) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        rpeInput.value = rpe;
        rpeInput.dispatchEvent(new Event('input'));
    }

    function cerrarModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        rpeInput.value = '';
        rpeInput.dispatchEvent(new Event('input'));
    }
</script>

<script>
    "use strict";

    (function () {
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        const SITEURL = "{{ url('/') }}";
        const table = $('#data-table');

        document.getElementById('filterBtn').addEventListener('click', () => filter());

        //Actualizar subareas select dependiendo el area
        document.getElementById('_area_filtro').addEventListener('change', (e) => {
            fetch(`${SITEURL}/subareas`, {
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
                var opciones = "<option value='all' style='color: blue;'>Todas</option>";
                for (let i in data.lsubarea) {
                    opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                        .subarea_nombre + '</option>';
                }
                document.getElementById("_subarea_filtro").innerHTML = opciones;
            }).catch(error => alert(error));
        });

        function filter() {
            fetch(`${SITEURL}/filtro-prestaciones-lentes`, {
                method: 'POST',
                body: JSON.stringify({
                    area: document.getElementById("_area_filtro").value,
                    subarea: document.getElementById("_subarea_filtro").value,
                    fechaInicial: document.getElementById('filtro_dia_inicio').value,
                    fechaFinal: document.getElementById('filtro_dia_fin').value,
                    "_token": "{{ csrf_token() }}"
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                },
            }).then(response => {
                if (!response.ok)
                    throw new Error('error');
                else
                    return response.json()
            }).then(data => {
                table.DataTable().clear();

                if(data.success) {
                    const { usuarios } = data;
                    const ultimaFechaActiva = new Date();
                    ultimaFechaActiva.setDate(ultimaFechaActiva.getDate() - 365);

                    usuarios.forEach(usuario => {
                        const nombreCompleto = [usuario.nombre, usuario.paterno, usuario.materno].join(' ');
                        const { lentes } = usuario;
                        let estatus = "";
                        
                        if(lentes) {
                            const fechaPrestacion = new Date(lentes.fecha_asignacion);
                            estatus = (fechaPrestacion.getTime() >= ultimaFechaActiva.getTime()) ? 'prestacion-activa' : 'prestacion-inactiva';
                        }

                        // "Calcular" acciones permitidas
                        let acciones = `
                            <div class="flex justify-center items-center rounded-lg gap-2 empty:hidden" role="group">`;
                                if(estatus != 'prestacion-activa') {
                                    acciones += `<button class="py-2 px-4 rounded-lg text-white font-bold bg-green-500 hover:bg-green-600"
                                        onclick="openModal('${usuario.rpe}');">Generar Solicitud</button>`
                                } else {
                                    const showPrestacionLentes_URL = '{{ route('lentes.show', ':id') }}'.replace(':id', lentes.id);
                                    acciones += `<a class="py-2 px-4 rounded-lg text-white font-bold bg-blue-500 hover:bg-blue-600"
                                        href=${showPrestacionLentes_URL}>Ver</a>`;
                                    @can('prestacion.edit')
                                        const editPrestacionLentes_URL = '{{ route('lentes.edit', ':id') }}'.replace(':id', lentes.id);
                                        acciones += `<a class="py-2 px-4 rounded-lg text-white font-bold bg-yellow-600 hover:bg-yellow-700"
                                            href=${editPrestacionLentes_URL}>Editar</a>`;
                                    @endcan
                                    @can('prestacion.delete')
                                        const deletePrestacionLentes_URL = '{{ route('lentes.destroy', ':id') }}'.replace(':id', lentes.id);
                                        acciones+= `<form id="formEliminar-${lentes.id}" method="POST" action="${deletePrestacionLentes_URL}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete(${lentes.id});" class="py-2 px-4 rounded-lg text-white font-bold bg-red-500 hover:bg-red-600">Eliminar</button>
                                                    </form>`;
                                    @endcan
                                }

                                if(lentes) {
                                    const historicoPrestacionLentes_URL = '{{ route('lentes.historico', ':rpe') }}'.replace(':rpe', usuario.rpe);
                                    acciones += `<a class="py-2 px-4 rounded-lg text-white font-bold bg-cyan-500 hover:bg-cyan-600"
                                            href="${historicoPrestacionLentes_URL}">Historial</a>`
                                }

                        acciones += `</div>`;

                        table.DataTable().row.add([
                            usuario.rpe,
                            nombreCompleto,
                            `<div class="${estatus}">${lentes ? lentes.fecha_asignacion : 'Sin solicitudes'}</div>`,
                            acciones
                        ]);
                    });
                }

                table.DataTable().draw();
            });
        }
    })();
</script>

<script>
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