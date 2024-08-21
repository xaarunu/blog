<x-app-layout>
    @section('title', 'DCJ - CFE: ProSalud')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PROSALUD') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection
    <style>
        .btn-editar {
            background-color: #ff8c00;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
        }
        .btn-editar:hover {
            background-color: #c8511b;
            color: white;
        }
        .miBoton {
            background-color: #0ca1f1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
        }

        .miBoton:hover {
            background-color: #148cb7;
            color: white;
        }
        .btn-eliminar {
            background-color: #ee0c0ceb; /* Color rojo coral */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
        }
        .btn-eliminar:hover {
            background-color: #9f1919;
            color: white;
        }
    </style>
    <div class="py-10">
        <x-boton-regresar />
        <div class="mx-auto sm:px-6 lg:px-8" style="width:95%;">
            @if(Auth::user()->hasAnyRole(['admin', 'Doctora']))
            <button id="_remitentetext" name="remitentetext" onclick="window.location='{{ route('prosalud.create') }}'" style="max-height: 40px; min-height: 40px; width: 210px; color: white; right: 2% " class="py-2 px-3 border-2 mb-2 border-blue-500 shadow-xl bg-blue-500 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent ">Crear nuevos resultados</button>
            @endif
            <div class="w-full flex justify-center items-center ">
                <div class="text-center p-4">
                    <div class="flex flex-row mb-3">
                        <div class="mr-4">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                            <select id="areaFilter" name="areaFilter"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="all">Todas las áreas</option>
                                @foreach($areas as $area)
                                    @if ($area->division_id === 'DX' && $area->area_clave !== 'DXSU')
                                        <option value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div  class="mr-4">
                            <label for="filtro_dia_inicio" class="block uppercase md:text-sm text-xs text-gray-500 font-semibold ">Fecha Inicio:</label>
                            <select id="filtro_fecha"name="filtro_fecha" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="all">Todos los años</option>
                                @foreach($años as $año)
                                        <option value="{{ $año}}">{{ $año}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="grid grid-rows-1 place-items-center mt-3">
                            <!-- botón Filtrar -->
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif
                            <button onclick="filter()" style="text-decoration:none;"
                                class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-1 ml-2">Filtrar</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>RPE</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Fecha de toma</th>
                            <th>Glucosa</th>
                            <th>Trigliceridos</th>
                            <th>Colesterol</th>
                            <th>Hemoglobina</th>
                            <th>Leucocitos</th>
                            <th>Plaquetas</th>
                            <th class="none">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->area_nombre}}</td>
                                <td>{{ $usuario->rpe }}</td>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->edad }}</td>
                                <td>{{ $usuario->fecha_toma }}</td>
                                <td>{{ $usuario->glucosa_resultado . ' ' . $usuario->glucosa_unidades }}</td>
                                <td>{{ $usuario->trigliceridos_resultado . ' ' . $usuario->trigliceridos_unidades }}</td>
                                <td>{{ $usuario->colesterol_resultado . ' ' . $usuario->colesterol_unidades }}</td>
                                <td>{{ $usuario->hemoglobina_resultado . ' ' . $usuario->hemoglobina_unidades }}</td>
                                <td>{{ $usuario->leucocitos_resultado . ' ' . $usuario->leucocitos_unidades }}</td>
                                <td>{{ $usuario->plaquetas_resultado . ' ' . $usuario->plaquetas_unidades }}</td>
                                <td>
                                    @if(auth()->user()->hasRole('JefeRecursosHumanos') || auth()->user()->hasRole('admin') )
                                    <form action="{{ route('salud.destroy', $usuario->id) }}" method="POST">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="error-message alert alert-danger bg-red-400 text-white p-4 rounded-lg mb-5">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>Inténtalo de nuevo. {{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @method('DELETE')
                                        <button type="submit" class="btn-eliminar">Eliminar</button>
                                    </form>
                                    @endif
                                    <button type="button" class="btn-editar" onclick="window.location='{{ route('prosalud.edit', $usuario->id) }}'">Editar</button>
                                    <button type="button" class="miBoton" onclick="window.location='{{ route('prosalud.show', $usuario->id) }}'">Detalles</button>
                                </td>
                            </tr>
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

        <script>
            const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
            var SITEURL = "{{ url('/') }}";

            function filter() {
                var area = document.getElementById('areaFilter').value;
                var fecha = document.getElementById('filtro_fecha').value;

                fetch('{{ route('prosalud.filtrar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        areaFilter: area,
                        filtro_fecha: fecha
                    })
                })
                .then(response => response.json())
                .then(data => {
                    actualizarTabla(data);
                })
                .catch(error => console.error('Error:', error));
            }

            function actualizarTabla(usuarios) {
            var table = $('#data-table').DataTable();
            table.clear().draw();

            usuarios.forEach(usuario => {
                    table.row.add([
                        usuario.area_nombre,
                        usuario.rpe,
                        usuario.nombre,
                        usuario.edad,
                        usuario.fecha_toma,
                        usuario.glucosa_resultado + ' ' + usuario.glucosa_unidades,
                        usuario.trigliceridos_resultado + ' ' + usuario.trigliceridos_unidades,
                        usuario.colesterol_resultado + ' ' + usuario.colesterol_unidades,
                        usuario.hemoglobina_resultado + ' ' + usuario.hemoglobina_unidades,
                        usuario.leucocitos_resultado + ' ' + usuario.leucocitos_unidades,
                        usuario.plaquetas_resultado + ' ' + usuario.plaquetas_unidades,
                        `
                            <form action="/salud/destroy/${usuario.id}" method="POST">
                                @csrf
                                @if ($errors->any())
                                <div class="error-message alert alert-danger bg-red-400 text-white p-4 rounded-lg mb-5">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>Inténtalo de nuevo. {{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                            <button type="button" class="btn-editar" onclick="window.location='./prosalud/edit/${usuario.id}'">Editar</button>
                            <button type="button" class="miBoton" onclick="window.location='./prosalud/${usuario.id}'">Detalles</button>
                        `
                    ]).draw(false);
                });
            }

        </script>


    @endsection
</x-app-layout>
