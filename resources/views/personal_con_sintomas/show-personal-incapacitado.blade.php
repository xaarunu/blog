<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personal con incapacitado') }}
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
        <div class="px-10 py-3 ml-11 leading-normal text-green-500 rounded-lg" role="alert">
            <div class="text-left">
                <a href="{{ route('salud.inicio') }}"
                    class='w-auto bg-green-500 hover-bg-green-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Regresar
                </a>
            </div>
        </div>
        <div class="alert" id="elementoOculto" style=" display: none; color: #571515; background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
            <p>No hay datos disponibles para mostrar en la tabla.</p>
        </div>
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        <div class="w-full flex justify-center items-center ">
            <div class="text-center p-4">
                <div class="flex flex-row mb-3">
                    <div class="mr-4" >
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Área:</label>
                        <select id="areaFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all">Todas las áreas</option>
                            @foreach($areas as $area)
                                @if ($area->division_id === 'DX' && $area->area_clave !== 'DXSU')
                                    <option value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                @endif
                            @endforeach
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
                            <th align="center">RPE</th>
                            <th align="center">Fecha</th>
                            <th align="center">Ultima nota médica </th>
                            <th align="center">Área</th>
                            <th align="center">Subárea</th>
                            <th class="none">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showPersonalIncapacitado as $personal)
                        <tr>
                            <td align="center">{{ $personal->rpe }}</td>
                            <td align="center">{{ $personal->fecha_fin }}</td>
                            <td align="center">
                                @php
                                    $NotasMedicaUsuario = $personal->user->user->salud;
                                @endphp
                                @if(!$NotasMedicaUsuario->isEmpty())
                                    {{ $NotasMedicaUsuario->last()->fecha }}
                                @else
                                    Sin nota médica.
                                @endif
                            </td>
                            <td align="center">{{ $personal->user->getArea->area_nombre }}</td>
                            <td align="center">{{ $personal->user->getSubarea->subarea_nombre}}</td>
                            <td class="none">
                                <div class="flex justify-center rounded-lg text-sm" role="group">
                                    <button class="mx-1 mt-3 border-right">
                                        <a href="{{ route('incapacidades_usuario.show', $personal->rpe) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">
                                            Seguimiento
                                        </a>
                                    </button>
                                    <form action="{{ route('personal_sintomas.marcarIncapacidadAtendida', $personal->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="mx-1 mt-3 border-right">
                                            <div class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                Atendido
                                            </div>
                                        </button>
                                    </form>
                                </div>

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

    @endsection
</x-app-layout>
{{-- Script de filtros --}}
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const SITEURL = "{{ url('/') }}";
    function filter() {
        var division = 'DX';
        var areaFilter = document.getElementById('areaFilter').value;
        var subareaFilter = document.getElementById('subareaFilter').value;
        const fecha_inicio = document.getElementById('filtro_dia_inicio').value;
        const fecha_fin = document.getElementById('filtro_dia_fin').value;
        fetch(SITEURL + '/filtroPersonalIncapacitado',{
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
            if (data.users.length === 0 ) {
                elementoOculto.style.display = "block"; // Mostrar el mensaje
                setTimeout(function () {
                    elementoOculto.style.display = "none"; // Ocultar el mensaje después de 3 segundos
                }, 3000);
            }
            // Agregar nuevos datos a la tabla
            const usuariosIncapacitados = data.users;

            usuariosIncapacitados.forEach(incapacitado => {
                let urlUsar = `{{route('incapacidades_usuario.show','rpe')}}`;
                urlUsar = urlUsar.replace('rpe',incapacitado.rpe);
                const optionsBtns = `
                <button class="mx-1 mt-3 border-right">
                    <a href="` + urlUsar + `" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">
                        Generar incapacidad
                    </a>
                </button>`;

                        const fechaUltimaNota = incapacitado.user.user.salud.length > 0
                        ? incapacitado.user.user.salud[0].fecha
                        : 'Sin nota médica.';

                dataTable.row.add([
                    incapacitado.rpe,
                    incapacitado.fecha_fin,
                    fechaUltimaNota,
                    incapacitado.user.area,
                    incapacitado.user.subarea,
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var areaFilter = document.getElementById('areaFilter');
        var subareaFilter = document.getElementById('subareaFilter');
        // Función para actualizar las opciones de subárea
        function updateSubareas() {
            var selectedArea = areaFilter.value;
            var subareas = document.querySelectorAll('#subareaFilter option');
            // Ocultar todas las opciones de subárea
            subareas.forEach(function(option) {
                option.style.display = 'none';
            });
            // Si se selecciona "Todas las áreas", mostrar todas las subáreas
            if (selectedArea === 'all') {
                document.querySelector('#subareaFilter option[value="all"]').style.display = 'block';
            } else {
                // Mostrar solo las subáreas correspondientes al área seleccionada
                document.querySelectorAll('#subareaFilter option[data-area="' + selectedArea + '"]').forEach(function(option) {
                    option.style.display = 'block';
                });
            }
        }
        // Actualizar las opciones de subárea cuando se cambia el filtro de área
        areaFilter.addEventListener('change', updateSubareas);
        // Llamar a la función para asegurar que las opciones de subárea estén actualizadas al cargar la página
        updateSubareas();
    });
</script>
