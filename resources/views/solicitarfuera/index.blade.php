<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consulta de vacaciones fuera de programa') }}
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
        @canany(['solicitarfuera.autorizar', 'solicitarfuera.rh', 'solicitarfuera.visto_bueno'])


            <div class="grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">
                <div class="grid grid-cols-1">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">División:</label>
                    <select id="_division_filtro" name="division_filtro"
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">

                        @if (Auth::user()->hasPermissionTo('solicitarfuera.autorizar'))
                            @foreach ($divisiones as $division)
                                <option <?php if ($division->division_clave == Auth::user()->datos->getDivision->division_clave) {
                                    print 'selected';
                                } ?> value="{{ $division->division_clave }}">
                                    {{ $division->division_nombre }}</option>
                            @endforeach
                        @else
                            <option value="{{ Auth::user()->datos->getDivision->division_clave }}">
                                {{ Auth::user()->datos->getDivision->division_nombre }}</option>
                        @endif

                    </select>
                </div>
                <div class="grid grid-cols-1">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                    <select id="_area_filtro" name="area_filtro"
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @if (Auth::user()->hasPermissionTo('solicitarfuera.rh') or Auth::user()->hasPermissionTo('solicitarfuera.autorizar'))
                            @foreach ($areas as $area)
                                <option <?php if ($area->area_clave == Auth::user()->datos->getArea->area_clave) {
                                    print 'selected';
                                } ?> value="{{ $area->area_clave }}"> {{ $area->area_nombre }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ Auth::user()->datos->getArea->area_clave }}">
                                {{ Auth::user()->datos->getArea->area_nombre }}</option>
                        @endif

                    </select>
                </div>
                <div class="grid grid-cols-1">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Subárea:</label>
                    <select id="_subarea_filtro" name="subarea_filtro"
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="0" style='color: blue;'>Todas</option>
                        @foreach ($subareas as $subarea)
                            <option <?php if ($subarea->subarea_clave == Auth::user()->datos->getSubarea->subarea_clave) {
                                print 'selected';
                            } ?> value="{{ $subarea->subarea_clave }}">
                                {{ $subarea->subarea_nombre }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <br>
            <div class="grid grid-rows-1 place-items-center mt-3">
                <!-- botón Filtrar -->
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif
                <button onClick="filter()" style="text-decoration:none;"
                    class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
            </div>
            <br>
        @endcanany
        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">RPE</th>
                            <th class="text-center">Nota</th>
                            <th class="text-center">Fecha de Inicio</th>
                            <th class="text-center">Fecha de Termino</th>
                            <th class="text-center">Días solicitados</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($solicitudes_fuera as $vacacion)
                            <tr>
                                <td align="center">{{ $vacacion->rpe }}</td>
                                <td align="center">{{ $vacacion->justificacion }}</td>
                                <td align="center">{{ $vacacion->fecha_Inicio }}</td>
                                <td align="center">{{ $vacacion->fecha_Fin }}</td>
                                <td align="center">{{ $vacacion->dias_solicitados }}</td>
                                <td align="center">{{ $vacacion->status }}</td>

                                <td align="center" class=" px-4 py-2">
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        @if (
                                            $vacacion->status == 'Pendiente' and Auth::user()->hasPermissionTo('solicitarfuera.visto_bueno') or
                                                $vacacion->status == 'Visto Bueno' and Auth::user()->hasPermissionTo('solicitarfuera.rh') or
                                                $vacacion->status == 'Pre-aprobado' and Auth::user()->hasPermissionTo('solicitarfuera.autorizar'))
                                            <a href="{{ route('solicitarfuera.show', $vacacion->id) }}"
                                                style="text-decoration: none"
                                                class="rounded bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 mx-1">Aprobar/Rechazar</a>
                                        @endif
                                        @if ($vacacion->status == 'Pendiente' and auth()->user()->rpe == $vacacion->rpe)
                                            <!-- botón editar -->
                                            <a href="{{ route('solicitarfuera.edit', $vacacion->id) }}"
                                                style="text-decoration: none"
                                                class="rounded bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 ml-2">Editar</a>
                                            <!-- botón borrar -->
                                            <form action="{{ route('solicitarfuera.destroy', $vacacion->id) }}"
                                                method="POST"
                                                class="formEliminar rounded bg-red-600 hover:bg-red-700 ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded text-black font-bold py-2 px-4">Borrar</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <br>
                <a href="{{ route('solicitarfuera.create') }}" style="background-color: rgb(21 128 61);"
                    class='w-auto bg-green-600 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Solicitar
                    Vacaciones</a>
                <br>
                <br>
            </div>

        </div>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.12.1/filtering/type-based/accent-neutralise.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#data-table').dataTable();
            });
        </script>
    @endsection
</x-app-layout>

<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la eliminación del registro?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Eliminado!',
                                'El registro ha sido eliminado exitosamente.', 'success');
                        }
                        //Se oculta el loader para que no tape toda la pantalla por siempre.
                        else{
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })
    })()
</script>



<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";

    function filter() {
        var f_division = document.getElementById("_division_filtro").value;
        var f_area = document.getElementById("_area_filtro").value;
        var f_subarea = document.getElementById("_subarea_filtro").value;
        var table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtrarVacacionesFuera', {
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
            //console.log(data.lista)
            var div_Init = "<td class='text-center' align='center'>";
            var div_End = "</td>";
            var rpe = "";
            var justificacion = "";
            var fecha_Inicio = "";
            var fecha_Fin = "";
            var dias_solicitados = "";
            var visto_bueno = "";
            var rh = "";
            var status = "";
            var status1 = "";
            var comentario = "";
            var acciones = "";
            if (data.solicitudes_vacaciones != null && data.solicitudes_vacaciones.length != 0) {
                for (let i in data.solicitudes_vacaciones) {
                    rpe = div_Init + data.solicitudes_vacaciones[i].rpe + div_End;
                    nota = div_Init + data.solicitudes_vacaciones[i].justificacion + div_End;

                    fecha_Inicio = div_Init + data.solicitudes_vacaciones[i].fecha_Inicio + div_End;
                    fecha_Fin = div_Init + data.solicitudes_vacaciones[i].fecha_Fin + div_End;
                    dias_solicitados = div_Init + data.solicitudes_vacaciones[i].dias_solicitados + div_End;
                    status = div_Init + data.solicitudes_vacaciones[i].status + div_End;

                    status1 = data.solicitudes_vacaciones[i].status;
                    var url = '{{ route('solicitarfuera.show', ':id') }}';
                    url = url.replace(':id', data.solicitudes_vacaciones[i].id);

                    if (data.botones[i] == 1) {
                        acciones = "<div class='px-4 py-2'>";
                        acciones += "<div class='flex justify-center rounded-lg text-lg' role='group'>";
                        acciones += "<a href= '" + url + "'" +
                            "style='text-decoration: none'" +
                            "class='rounded bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 mx-1'>Aprobar/Rechazar</a>  </div></div>";
                    }

                    table.row.add([
                        rpe,
                        nota,
                        fecha_Inicio,
                        fecha_Fin,
                        dias_solicitados,
                        status,
                        acciones
                    ]);
                }
            } else {
                throw new Error('error');
            }

            table.draw();


        }).catch(error => {
            Swal.fire(
                'No se han encontrado usuarios con esas características',
                'Prueba de nuevo, modificando los filtros',
                'question'
            )
        });
    }

    //Actualizar areas select dependiendo la division
    document.getElementById('_division_filtro').addEventListener('change', (e) => {
        fetch(SITEURL + '/areas', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].area_clave + '">' + data.lista[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("_area_filtro").innerHTML = opciones;

            fetch(SITEURL + '/subarea', {
                method: 'POST',
                body: JSON.stringify({
                    texto: data.lista[0].area_clave,
                    "_token": "{{ csrf_token() }}"
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                },
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "";
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].subarea_clave + '">' + data
                        .lista[i].subarea_nombre + '</option>';
                }
                opciones += "<option value='0' style='color: blue;'>Todas</option>";
                document.getElementById("_subarea_filtro").innerHTML = opciones;
            }).catch(error => alert(error));

        }).catch(error => alert(error));
    })

    //Actualizar subareas select dependiendo el area
    document.getElementById('_area_filtro').addEventListener('change', (e) => {
        fetch(SITEURL + '/subarea', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].subarea_clave + '">' + data.lista[i]
                    .subarea_nombre + '</option>';
            }
            opciones += "<option value='0' style='color: blue;'>Todas</option>";
            document.getElementById("_subarea_filtro").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
