<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('USUARIOS') }}
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
        @if (Session::has('message'))
            <div class="alert-{{ session('message_type') }} w-80 md:w-1/2 mx-auto py-8 px-4" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @php $mostrarDivision = Auth::user()->hasRole('admin'); @endphp

        <div class="grid grid-cols-2 md:grid-cols-{{ $mostrarDivision ? 4 : 3}} gap-5 md:gap-8 mt-5 mx-7">
            <div class="@if($mostrarDivision) grid grid-cols-1 @else hidden @endif">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">División:</label>
                <select id="_division_filtro" name="division_filtro"
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @if($mostrarDivision)
                        @foreach ($divisiones as $division)
                            <option <?php if ($division->division_clave == Auth::user()->datos->getDivision->division_clave) {
                                print 'selected';

                            } ?> value="{{ $division->division_clave }}">{{ $division->division_nombre }}</option>
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
                            <option <?php if ($area->area_clave == Auth::user()->datos->getArea->area_clave) {
                                print 'selected';
                            } ?> value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
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
                        <option  <?php  if ($subarea->subarea_clave == Auth::user()->datos->getSubarea->subarea_clave) {
                            print 'selected';
                        } ?> value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Rol:</label>
                <select id="_rol_filtro" name="rol_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todos</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
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
        <br>

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <!--            <button type="submit" class="rounded text-white font-bold py-2 px-4">Borrar</button> -->

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">

                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>

                            <th>RPE</th>
                            <th>Correo</th>
                            <th>Puesto</th>
                            <th>Centro de trabajo</th>
                            <th>Antiguedad</th>
                            @canany(['users.edit', 'users.destroy', 'users.usuariosBaja'])
                                <th class="none">Acciones</th>
                            @endcanany

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if (App\Models\DatosUser::where('rpe', $user->rpe)->get()->first() != null)
                                <!--Revisa si el usuario tiene datos-->
                                @if ($datos[$user->rpe]->contrato == '4' || $datos[$user->rpe]->contrato == '3')
                                    @continue
                                @endif
                                <tr data-id="{{ $user->id }}">
                                    <td class="px-6 py-4 text-center mostrar-usuario">
                                        <div>
                                            {{ $user->rpe }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center mostrar-usuario">
                                        <div>
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center mostrar-usuario">
                                        <div>
                                            {{ $datos[$user->rpe]->puesto }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center mostrar-usuario">
                                        <div>
                                            {{ $datos[$user->rpe]->subarea }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center mostrar-usuario">
                                        <div>
                                            {{ $datos[$user->rpe]->antiguedad }}
                                        </div>
                                    </td>


                                    @canany(['users.edit', 'users.destroy', 'users.usuariosBaja'])
                                        <td class="px-4 py-2">
                                            <div class="flex justify-center rounded-lg text-lg" role="group">
                                                @can('users.edit')
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        style="text-decoration: none"
                                                        class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 mx-1">Editar</a>
                                                @endcan
                                                @can('users.destroy')
                                                    <form id="formEliminar-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        class="rounded bg-red-600 hover:bg-red-700 mx-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete({{ $user->id }});"
                                                            class="rounded text-white font-bold py-2 px-4">Borrar</button>
                                                    </form>
                                                @endcan
                                                @can('users.usuariosBaja')
                                                    <form action="{{ route('users.bajar') }}" method="POST"
                                                        class="formBajar rounded bg-gray-500 hover:bg-gray-600 text-white font-bold mx-1">
                                                        @csrf
                                                        <input type="text" class="hidden" name="id"
                                                            value="{{ $user->id }}">
                                                        <button type="submit"
                                                            class="rounded text-white font-bold py-2 px-4">Baja</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                </table>
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
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
        var formas = document.querySelectorAll('.formBajar')
        Array.prototype.slice.call(formas)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la baja del registro?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Dado de baja!',
                                'El registro ha sido dado de baja exitosamente.', 'success');
                        } else {
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })

    })()

    function changeRole(id) {
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        var rol = document.getElementById(id + 'select').value;
        fetch('users/' + id, {
            method: 'PUT',
            body: JSON.stringify({
                rol: rol,
                origen: 'fetch',
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).catch(error => alert(error));

    }

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const SITEURL = "{{ url('/') }}";

    function filter() {
        const f_division = document.getElementById("_division_filtro").value;
        const f_area = document.getElementById("_area_filtro").value;
        const f_subarea = document.getElementById("_subarea_filtro").value;
        const f_rol = document.getElementById("_rol_filtro").value;
        const table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtrarUsuarios', {
            method: 'POST',
            body: JSON.stringify({
                division: f_division,
                area: f_area,
                subarea: f_subarea,
                rol: f_rol,
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
            var rpe = "";
            var email = "";
            var puesto = "";
            var subarea = "";
            var antiguedad = "";
            var acciones = "";
            var rpe_string = "";
            if (data.users != null && data.users.length != 0) {
                for (let i in data.users) {
                    rpe_string = data.users[i].rpe;
                    rpe = div_Init + data.users[i].rpe + div_End;
                    email = div_Init + data.users[i].email + div_End;

                    if (data.datos[rpe_string].puesto != null) {
                        puesto = div_Init + data.datos[rpe_string].puesto + div_End;
                    }
                    else {
                        puesto = div_Init + div_End;
                    }

                    subarea = div_Init + data.datos[rpe_string].subarea + div_End;

                    if(data.datos[rpe_string].antiguedad != null) {
                        antiguedad = div_Init + data.datos[rpe_string].antiguedad + div_End;
                    }
                    else {
                        antiguedad = div_Init + div_End;
                    }


                    @canany(['users.edit', 'users.destroy', 'users.usuariosBaja'])
                        acciones = "<div class='px-4 py-2'>";
                        acciones += "<div class='flex justify-center rounded-lg text-lg' role='group'>";

                        @can('users.edit')
                            let url = '{{ route('users.edit', ':id') }}';
                            url = url.replace(':id', data.users[i].id);
                            acciones += "<a href= '" + url + "'" +
                                "style='text-decoration: none'" +
                                "class='rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 mx-1'>Editar</a> ";
                        @endcan
                        @can('users.destroy')
                            url = '{{ route('users.destroy', ':id') }}';
                            url = url.replace(':id', data.users[i].id);
                            acciones += `<form id="formEliminar-${data.users[i].id}" action="${url}" method="POST"
                                            class="rounded bg-red-600 hover:bg-red-700 mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(${data.users[i].id});"
                                                class="rounded text-white font-bold py-2 px-4">Borrar</button>
                                        </form>`
                        @endcan
                        @can('users.usuariosBaja')
                            acciones += `<form action="{{ route('users.bajar') }}" method="POST"
                                            class="formBajar rounded bg-gray-500 hover:bg-gray-600 text-white font-bold mx-1">
                                            @csrf
                                            <input type="text" class="hidden" name="id"
                                                value="${data.users[i].id}">
                                            <button type="submit"
                                                class="rounded text-white font-bold py-2 px-4">Baja</button>
                                        </form>`
                        @endcan

                        acciones += "</div></div>";
                    @endcanany
                    table.row.add([
                        rpe,
                        email,
                        puesto,
                        subarea,
                        antiguedad,
                        @canany(['users.edit', 'users.destroy', 'users.usuariosBaja'])
                            acciones
                        @endcanany
                    ]);
                }
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
