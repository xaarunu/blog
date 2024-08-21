<x-app-layout>
    @section('title', 'DCJ - CFE: Audiometrías')

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audiometrías') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <x-boton-regresar />
        @php $mostrarDivision = Auth::user()->hasAnyRole(['admin', 'Doctora']); @endphp
        <div class="grid grid-cols-2 md:grid-cols-{{ $mostrarDivision ? 3 : 2}} gap-5 md:gap-8 mt-5 mx-auto w-75">
            <div class="@if($mostrarDivision) grid grid-cols-1 @else hidden @endif">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">División:</label>
                <select id="_division_filtro" name="division_filtro"
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @if($mostrarDivision)
                        @foreach ($divisiones as $division)
                            <option @if($division->division_clave == Auth::user()->datos->getDivision->division_clave) selected @endif value="{{ $division->division_clave }}">{{ $division->division_nombre }}</option>
                        @endforeach
                    @else
                        <option selected value="{{ Auth::user()->datos->getDivision->division_clave }}"></option>
                    @endif
                </select>
            </div>
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
                        <option  @if($subarea->subarea_clave == Auth::user()->datos->getSubarea->subarea_clave) selected @endif value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-rows-1 place-items-center mt-7">
            <button onclick="filter()" style="text-decoration: none;"
                class="rounded bg-blue-500 text-white font-bold py-2 px-3 mx-2 ml-2 hover:bg-blue-600">Filtrar</button>
        </div>

        <div class="grid grid-rows-1 place-items-center mt-6">
            @if (\Session::has('success'))
                <div class="alert alert-success text-center mb-0" role="alert">
                    <ul class="mb-0 py-3">
                        <li><span> {!! \Session::get('success') !!} </span></li>
                    </ul>
                </div>
            @endif
        </div>

        <!-- Tabla de audiometrias -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 mx-auto mt-12 py-2 sm:w-11/12 md:w-9/12">
            <table id="data-table" class="stripe hover translate-table w-full py-4">
                <thead>
                    <tr>
                        <th>RPE</th>
                        <th>Nombre</th>
                        <th>Diagnostico oido Izquierdo</th>
                        <th>Diagnostico oido Derecho</th>
                        <th>Fecha del estudio</th>
                        @canany(['audiometria.edit', 'audiometria.delete'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audiometrias as $audiometria)
                    <tr>
                        <td>{{ $audiometria->rpe }}</td>
                        <td>{{ $audiometria->user->nombre }}</td>
                        <td>{{ $diagnosticos[$audiometria->oido_izquierdo - 1]->diagnostico }}</td>
                        <td>{{ $diagnosticos[$audiometria->oido_derecho - 1]->diagnostico }}</td>
                        <td>{{ $audiometria->fecha_toma }}</td>
                        @canany(['audiometria.edit', 'audiometria.delete'])
                        <td>
                            <div class="flex justify-center rounded-lg text-lg" role="group">
                                @can('audiometria.edit')
                                <a href="{{ route('audiometrias.edit', $audiometria->id) }}" style="text-decoration: none"
                                    class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2">Editar</a>
                                @endcan
                                @can('audiometria.delete')
                                <form id="formEliminar-{{ $audiometria->id }}" action="{{ route('audiometrias.destroy', $audiometria->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="confirmDelete({{ $audiometria->id }})" type="button" style="text-decoration: none"
                                        class="rounded-lg bg-red-600 hover:bg-red-700 text-black hover:text-white font-bold py-2 px-4 ml-2">Eliminar</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex items-center justify-center  md:gap-8 gap-4 pb-5" style="display:flex; gap:10px;">
                <!-- botón volver -->
                <a type="button" href="{{ route('datos.index') }}" style="text-decoration:none"
                    class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                <!-- botón crear -->
                <a type="button" href="{{ route('audiometrias.create') }}" style="text-decoration:none"
                    class="rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4">Crear</a>
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
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";

    function filter() {
        var f_division = document.getElementById("_division_filtro").value;
        var f_area = document.getElementById("_area_filtro").value;
        var f_subarea = document.getElementById("_subarea_filtro").value;
        var table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtrarUsuariosAudiometrias', {
            method: 'POST',
            body: JSON.stringify({
                division: f_division,
                area: f_area,
                subarea: f_subarea,
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

            const div_Init = "<td class='px-6 py-4 text-center mostrar-usuario'>";
            const div_End = "</td>";

            let rpe = "";
            let nombre = "";
            let oido_izquierdo = "";
            let oido_derecho = "";
            let fecha_estudio = "";
            let acciones = "";

            diagnosticos = data.diagnosticos;

            if(data.audiometrias && data.audiometrias.length > 0) {
                data.audiometrias.forEach(res => {
                    // Datos calculados
                    const nombreCompleto = [res.user.nombre, res.user.paterno, res.user.materno].join(' ');

                    // Campos
                    rpe = `${div_Init} ${res.rpe} ${div_End}`
                    nombre = `${div_Init} ${nombreCompleto} ${div_End}`
                    oido_izquierdo = `${div_Init} ${diagnosticos.find(d => d.id == res.oido_izquierdo).diagnostico} ${div_End}`
                    oido_derecho = `${div_Init} ${diagnosticos.find(d => d.id == res.oido_derecho).diagnostico} ${div_End}`
                    fecha_estudio = `${div_Init} ${res.fecha_toma} ${div_End}`

                    @canany(['audiometria.edit', 'audiometria.delete'])
                        acciones = div_Init + '<div class="flex justify-center rounded-lg text-lg" role="group">';

                        @can('audiometria.edit')
                            const editarAudiometria_URL = '{{ route('audiometrias.edit', ':id') }}'.replace(':id', res.id);
                            acciones += `<a href="${editarAudiometria_URL}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Editar</a>`;
                        @endcan
                        @can('audiometria.delete')
                            const elimimarAudiometria_URL = '{{ route('audiometrias.destroy', ':id') }}'.replace(':id', res.id);
                            acciones += `<form id="formEliminar-${res.id}" action="${elimimarAudiometria_URL}" method="POST" class="inline-block"> @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete(${res.id})" style="text-decoration: none" class="formEliminar rounded-lg bg-red-600 hover:bg-red-700 text-black hover:text-white font-bold py-2 px-4 ml-2">Eliminar</button>
                                        </form>`;
                        @endcan
                        acciones += '</div>' + div_End;
                    @endcanany

                    table.row.add([
                        rpe,
                        nombre,
                        oido_izquierdo,
                        oido_derecho,
                        fecha_estudio,
                        acciones
                    ]);
                })
            }
           table.draw();
        }).catch(error => {
            // Error en relación (audiometría no tiene user vinculado)
            if(error instanceof TypeError){
                console.error("Verifica los datos en la BD");
            } else {
                Swal.fire(
                    'No se han encontrado audiometrias con esas características',
                    'Prueba de nuevo, modificando los filtros',
                    'question'
                )
            }
        });
    }

    //Actualizar areas select dependiendo la division
    document.getElementById('_division_filtro').addEventListener('change', (e) => {
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
            var opciones = "<option value='0' style='color: blue;'>Todas</option>";
            for (let i in data.lareas) {
                opciones += '<option value="' + data.lareas[i].area_clave + '">' + data.lareas[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("_area_filtro").innerHTML = opciones;

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
                var opciones = "<option value='0' style='color: blue;'>Todas</option>";
                for (let i in data.lsubarea) {
                    opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data
                        .lsubarea[i].subarea_nombre + '</option>';
                }
                document.getElementById("_subarea_filtro").innerHTML = opciones;
            }).catch(error => alert(error));

        }).catch(error => alert(error));
    })

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
