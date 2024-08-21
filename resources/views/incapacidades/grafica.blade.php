<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Gráfica de incapacidades') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">
        @if (!isset($RijIncapacidad) || $RijIncapacidad == false)
            <div class="flex justify-center">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-8 mx-7">
                    {{-- División --}}
                    <div class="grid grid-cols-1">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">División:</label>
                        <select id="_division_filtro" name="division_filtro"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="0" style='color: blue;'>Todas</option>
                            @foreach ($divisiones as $division)
                                <option value="{{ $division->division_clave }}">{{ $division->division_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Por --}}
                    <div class="grid grid-cols-1">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Por:</label>
                        <select id="_area_filtro" name="area_filtro"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="0">Mes</option>
                            <option value="1">Semana</option>
                        </select>
                    </div>

                    {{-- Fecha Inicio --}}
                    <div class="grid grid-cols-1">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha
                            Inicio:</label>
                        <input onchange="calcularDias();" id="fecha_inicio" name="fecha_inicio" type="date"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required />
                    </div>

                    {{-- Fecha Fin --}}
                    <div class="grid grid-cols-1">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin:</label>
                        <input onchange="calcularDias();" id="fecha_fin" name="fecha_fin" type="date"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required />
                    </div>
                </div>
            </div>
            <br>
            <div class="grid place-items-center mt-3">
                <!-- botón Filtrar -->
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif
                <button onClick="filter()" class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3">
                    Filtrar
                </button>
            </div>
            <br>
        @endif

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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 border-4 p-4">
                <canvas id="incapacidades-chart" style="width:100%; height:400px;"></canvas>
            </div>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            function renderChart(data) {
                var ctx = document.getElementById('incapacidades-chart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item.fecha),
                        datasets: [{
                            label: 'Número de Incapacidades',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: data.map(item => item.total),
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            function filter() {
                var f_division = document.getElementById("_division_filtro").value;
                var f_area = document.getElementById("_area_filtro").value;
                var f_inicio = document.getElementById("fecha_inicio").value;
                var f_fin = document.getElementById("fecha_fin").value;

                fetch("{{ route('obtenerIncapacidades') }}", {
                        method: 'POST',
                        body: JSON.stringify({
                            division: f_division,
                            area: f_area,
                            fecha_inicio: f_inicio,
                            fecha_fin: f_fin,
                            "_token": "{{ csrf_token() }}"
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": "{{ csrf_token() }}"
                        },
                    }).then(response => response.json())
                    .then(data => renderChart(data))
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endsection
</x-app-layout>
