<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Histórico de padecimientos
        </h2>
    </x-slot>
    <x-boton-regresar />
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <div class="col-sm-12 mb-5">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-auto" style="width: 85%; padding: 40px 40px 40px 50px;">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-8 mt-5 mb-2 mx-7">
                <div class="grid grid-cols-1">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Zona:</label>
                    <select id="area" name="area" @if($role) disabled @endif
                        class="block py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="0">Todas</option>
                        @foreach ($areas as $area)
                            <option id="{{ $area->area_clave }}" @if ($area->area_clave == Auth::user()->datos->getArea->area_clave && $role) selected @endif value="{{$area->area_clave}}" >{{ $area->area_nombre }} </option> 
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Indices:</label>
                    <select id="indice" name="indice" 
                        class="block py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="bajo">Indice Bajo</option>
                        <option value="normal" selected>Indice Normal</option>
                        <option value="alto">Indice Alto</option>
                    </select>
                </div>
                {{-- <div>
                    <h3>Estadísticas de Incapacidades</h3>
                    <div>
                        <p>Total de Incapacidades: <span id="totalIncapacidades">{{$numeroProsalud}}</span></p>
                    </div>
                </div> --}}
            </div>
            <div class="flex justify-center ml-8" style="width: 50%;">
                <button id="btn1" type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                    Filtrar
                </button>
            </div>
            <canvas id="graficaProSalud" width="400" height="200"></canvas>
        </div>
    </div>
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/pikaday/pikaday.css')}}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    @endsection
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{asset('plugins/chart/AlterChart.min.js')}}"></script>
        <script src="{{asset('plugins/pikaday/pikaday.js')}}"></script>
        <script src="{{asset('plugins/chart/DatalabelsChartPlugin.min.js')}}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
</x-app-layout>
    <script>
        let graficaProSalud;

        $(document).ready(function() {
            const enviar = document.querySelector('#btn1');
            enviar.addEventListener('click', (e) => {
                var area = document.getElementById('area').value;
                var indice = document.getElementById('indice').value;
                const url = "{{ route('estadisticas.prosalud.filtrarArea') }}"; 
                const data = { 
                    area: area,
                    indice: indice,
                }
                solicitud('GET', data, url, filtrar);
            });

            const ctx = document.getElementById('graficaProSalud').getContext('2d');
            const años = @json($años);
            const resultados = @json($resultados);

            const data = {
                labels: años,
                datasets: crearDatasets(resultados, 'normal')
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Resultados Históricos por Año'
                        }
                    }
                }
            };

            graficaProSalud = new Chart(ctx, config);
        });

        function filtrar(response) { 
            graficaProSalud.data.labels = response.años;
            graficaProSalud.data.datasets = crearDatasets(response.resultados, 'resultado');
            graficaProSalud.update();
        }

        function solicitud(type, data, url, funcion) {
            const token = '{{ csrf_token() }}'; 
            data._token = token; 
            $.ajax({
                type: type,
                data: data,
                url: url,
                success: funcion,  
                error: (xhr, status, error) => {
                    console.log('Error al buscar:', error);
                },
            });
        }

        function crearDatasets(resultados, tipo) {
            return [
                {
                    label: 'Glucosa',
                    data: resultados[`glucosa_${tipo}`],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false,
                },
                {
                    label: 'Triglicéridos',
                    data: resultados[`trigliceridos_${tipo}`],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: false,
                },
                {
                    label: 'Colesterol',
                    data: resultados[`colesterol_${tipo}`],
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    fill: false,
                },
                {
                    label: 'Hemoglobina',
                    data: resultados[`hemoglobina_${tipo}`],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                },
                {
                    label: 'Leucocitos',
                    data: resultados[`leucocitos_${tipo}`],
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: false,
                },
                {
                    label: 'Plaquetas',
                    data: resultados[`plaquetas_${tipo}`],
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: false,
                }
            ];
        }

    </script>
