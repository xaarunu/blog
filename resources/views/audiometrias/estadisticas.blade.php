<x-app-layout>
    @section('title', 'DCJ - CFE: Estadística audiometrías')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Informe de resultados por zona') }}
        </h2>
    </x-slot>
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <x-boton-regresar />

    <div class="w-full flex justify-center items-center">
        <div class="card mt-4 px-2 py-2 mx-4 rounded-lg shadow-lg m-4"
            style="background-color: white; width: 1200px; height: 1000;">
            {{-- Filtro --}}
            <div class="text-center p-4">
                <form class="flex flex-wrap items-center justify-center mb-3 gap-4" action="{{route('audiometria.estadisticas')}}" method="GET">
                    {{-- DIVISIÓN --}}
                    @php $mostrarDivision = Auth::user()->hasAnyRole(['admin', 'Doctora']); @endphp
                    <div>
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">División:</label>
                        <select @if (!$mostrarDivision) disabled @endif id="_division_filtro" name="division"
                            class="min-w-40 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @if($mostrarDivision)
                                @foreach($divisiones as $division)
                                    <option value="{{ $division->division_clave }}"
                                        {{$division->division_clave == $selectedDivision ? 'selected' : ''}}
                                        >{{ $division->division_nombre }}</option>
                                @endforeach
                            @else
                                <option selected value="{{ Auth::user()->datos->division }}">{{ Auth::user()->datos->getDivision->division_nombre }}</option>
                            @endif
                        </select>
                    </div>
                    {{-- ÁREA --}}
                    <div>
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Área:</label>
                        <select @if (!$mostrarDivision) disabled @endif id="_area_filtro" name="area"
                            class="min-w-40 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @can('controlDivisional')
                                <option value="all" style="color: blue;">Todas las áreas</option>
                                @foreach ($areas as $area)
                                    <!-- Evaluar antes si se tiene una "solicitud" de área especifica -->
                                    @if(Request::get('area'))
                                        @if(Request::get('area') === $area->area_clave)
                                            <option value="{{ $area->area_clave }}" selected>{{ $area->area_nombre }}</option>
                                        @else
                                            <option value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                        @endif
                                    @else
                                        <option @if ($area->area_clave == Auth::user()->datos->getArea->area_clave) selected @endif value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                    @endif
                                @endforeach
                            @else
                                <option selected value="{{ Auth::user()->datos->getArea->area_clave }}">{{ Auth::user()->datos->getArea->area_nombre}}</option>
                            @endcan
                        </select>
                    </div>
                    {{-- SUBÁREA --}}
                    <div>
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Subárea:</label>
                        <select @if (!$mostrarDivision) disabled @endif id="_subarea_filtro" name="subarea"
                            class="min-w-40 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all" style="color: blue;">Todas las subáreas</option>
                            @foreach($subareas as $subarea)
                                @if (Request::get('subarea') === $subarea->subarea_clave)
                                    <option value="{{ $subarea->subarea_clave }}" selected>{{ $subarea->subarea_nombre }}</option>
                                @else
                                    <option selected value="{{ Auth::user()->datos->getSubarea->subarea_clave }}">{{ Auth::user()->datos->getSubarea->subarea_nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-rows-1 place-items-center mt-3">
                        <button type="submit" class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2" style="text-decoration:none;">Filtrar</button>
                    </div>
                </form>
            </div>
            <h3 class="px-2 text-xl justify-center flex">
                De {{ $usuariosTotales }} usuarios totales,
                @if($totalAudiometrias == 1)
                    hay 1 audiometría registrada.
                @else
                    hay {{ $totalAudiometrias }} audiometrías registradas.
                @endif
            </h3>

            <!-- Gráfica general -->
            <div class="flex gap-3 justify-center my-4">
                @if($totalAudiometrias < 1)
                <center>
                    <div class="message-overlay" id="noDataMessage">
                        <p>No hay datos disponibles para mostrar.</p>
                    </div>
                </center>
                @else
                <!-- Gráficas de pastel -->

                    <center id = "izquierdo" class="w-5/12" >
                        <h3 class="text-lg">Resultados en oido izquierdo</h3>
                        <div id="canvasContainer" style="width:100%; position:relative;">
                            <canvas id="oidoIzquierdoChart"></canvas>
                        </div>
                    </center>
                    <center id= "derecho" class="w-5/12" >
                        <h3 class="text-lg">Resultados en oido derecho</h3>
                        <div id="canvasContainer">
                            <canvas id="oidoDerechoChart" class="w-full"></canvas>
                        </div>
                    </center>
                @endif
            </div>
                {{-- tabla de detalles --}}
                <div class="flex gap-3 justify-center my-4 bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                    <table id="data-table" class="stripe hover translate-table"
                        style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                            <tr>
                                <th>División</th>
                                <th>Área</th>
                                <th>Subarea</th>
                                <th>RPE</th>
                                <th>Nombre</th>
                                <th>Oido izquierdo</th>
                                <th>Oido derecho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->division_nombre}}</td>
                                    <td>{{ $usuario->area_nombre}}</td>
                                    <td>{{ $usuario->subarea_nombre }}</td>
                                    <td>{{ $usuario->rpe }}</td>
                                    <td>{{ $usuario->user->nombre . " " . $usuario->user->paterno . " " . $usuario->user->materno }}</td>

                                    <td>
                                        @if($usuario->oido_izquierdo == 1)
                                            Audición normal
                                        @elseif($usuario->oido_izquierdo == 2)
                                            Hipoacusia leve
                                        @elseif($usuario->oido_izquierdo == 3)
                                            Hipoacusia moderada
                                        @endif
                                    </td>
                                    <td>
                                        @if($usuario->oido_derecho == 1)
                                            Audición normal
                                        @elseif($usuario->oido_derecho == 2)
                                            Hipoacusia leve
                                        @elseif($usuario->oido_derecho == 3)
                                            Hipoacusia moderada
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>

    </div>



</x-app-layout>
<script src={{asset('plugins/chart/Chart.min.js')}}></script>
<script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/customDataTables.js') }}"></script>
<script>


    const derecho_ctx = document.getElementById('oidoDerechoChart').getContext('2d');
    const izquierdo_ctx = document.getElementById('oidoIzquierdoChart').getContext('2d');

    const etiquetasResultados = @json($etiquetas);

    const dataIzquierdos = Object.values(@json($resultadosIzquierdo));
    const dataDerechos = Object.values(@json($resultadosDerecho));




    const totalUsuarios = Object.values(@json($usuarios));
    const total = totalUsuarios.length;
    const mostrarDerecho = dataDerechos.length;
    const mostrarIzquierdo = dataIzquierdos.length;


    if(total == 1){
        if (mostrarDerecho < 3) {
            document.getElementById('derecho').style.display = 'block';
            let derechoChart = new Chart(derecho_ctx, {
                type: 'pie',
                data: {
                    labels: etiquetasResultados,
                    datasets: [{
                        data: dataDerechos,
                        backgroundColor: ['#97e2dd', '#648ba4'],
                    }]
                }
            });
        } else {
            document.getElementById('derecho').style.display = 'none';
        }

        if (mostrarIzquierdo < 3 ) {
            document.getElementById('izquierdo').style.display = 'block';
            let izquierdoChart = new Chart(izquierdo_ctx, {
                type: 'pie',
                data: {
                    labels: etiquetasResultados,
                    datasets: [{
                        data: dataIzquierdos,
                        backgroundColor: ['#97e2dd', '#648ba4'],
                    }]
                }
            });
        } else {
            document.getElementById('izquierdo').style.display = 'none';
        }
    }else{

        const eliminar = (arr) => {
            if (arr.length === 3) {
                arr.shift();
            }
        };

        eliminar(dataIzquierdos);
        eliminar(dataDerechos);
        document.getElementById('derecho').style.display = 'block';
            let derechoChart = new Chart(derecho_ctx, {
                type: 'pie',
                data: {
                    labels: etiquetasResultados,
                    datasets: [{
                        data: dataDerechos,
                        backgroundColor: ['#97e2dd', '#648ba4'],
                    }]
                }
            });
        document.getElementById('izquierdo').style.display = 'block';
            let izquierdoChart = new Chart(izquierdo_ctx, {
                type: 'pie',
                data: {
                    labels: etiquetasResultados,
                    datasets: [{
                        data: dataIzquierdos,
                        backgroundColor: ['#97e2dd', '#648ba4'],
                    }]
                }
            });
    }

</script>
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const SITEURL = "{{ url('/') }}";

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
            return response.json();
        }).then(data => {
            let opciones = "<option value='all' style='color: blue;'>Todas las áreas</option>";
            for (let i in data.lareas) {
                opciones += '<option value="' + data.lareas[i].area_clave + '">' + data.lareas[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("_area_filtro").innerHTML = opciones;
            document.getElementById("_subarea_filtro").innerHTML = "<option value='all' style='color: blue;'>Todas las subáreas</option>";
        }).catch(error => alert(error));
    });

    document.getElementById('_area_filtro').addEventListener('change', (e) => {
        fetch(SITEURL + '/subareas', {
            method: 'POST',
            body: JSON.stringify({
                area: e.target.value,
                '_token': '{{ csrf_token() }}'
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
        }).then(response => {
            return response.json();
        }).then(data => {
            let opciones = "<option value='all' style='color: blue;'>Todas las subáreas</option>";

            for (const subarea of data.lsubarea) {
                opciones += `<option value="${subarea.subarea_clave}">${subarea.subarea_nombre}</option>`
            }
            document.getElementById("_subarea_filtro").innerHTML = opciones;
        }).catch(error => alert(error));
    });
</script>
