<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Padecimientos Estadisticas
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
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Inicio:</label>
                    <input id="fecha_Inicio" name="fecha_Inicio"
                    class="py-2 px-3 rounded-lg border-2 text-black border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        type="date" required />
                </div>
                <div class="grid grid-cols-1">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin:</label>
                    <input id="fecha_Fin" name="fecha_Fin"
                    class="py-2 px-3 rounded-lg border-2 text-black border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        type="date" required />
                </div>
                <div>
                    <h3>Estadísticas de Incapacidades</h3>
                    <div>
                        <p>Total de Incapacidades: <span id="totalIncapacidades">{{$numeroIncapacidades}}</span></p>
                    </div>
                </div>
            </div>
            <div class="flex justify-center ml-8" style="width: 50%;">
                <button id="btn1" type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                    Filtrar
                </button>
            </div>
            <canvas id="graficaPadecimientos"></canvas>
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
    let miGrafica;

    $(document).ready(function() {
        const enviar = document.querySelector('#btn1');
        enviar.addEventListener('click', (e) => {
            var area = document.getElementById('area').value;
            var fecha_Inicio = document.getElementById('fecha_Inicio').value;
            var fecha_Fin = document.getElementById('fecha_Fin').value;
            const url = "{{ route('estadisticas.incapacidades.filtrarGrafica') }}"; 
            const data = { 
                area: area,
                fecha_Inicio: fecha_Inicio,
                fecha_Fin: fecha_Fin,
            }
            solicitud('GET', data, url, filtrar);
        });

        var ctx = document.getElementById('graficaPadecimientos').getContext('2d');
        miGrafica = new Chart(ctx, {
            type: 'bar',
            data: {
                legend: 'Resultados',
                labels: @json($labels),
                datasets: [{
                    label: 'Número de Incapacidades',
                    data: @json($valores),
                    backgroundColor: ["#4E79A7", "#F28E2B", "#E15759", "#76B7B2", "#59A14F", "#EDC949", "#AF7AA1", "#FF9DA7", "#9C755F", "#BAB0AC", "#D37295", "#8CD17D"],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: '',
                        font: {
                            size: 24,
                        },
                    },
                    datalabels: {
                        color: '#000000',
                        anchor: 'end',
                        align: 'end',
                        formatter: function(value, context) {
                            return value; 
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            },
            plugins: [ChartDataLabels]
        });
    });

    const filtrar = (response) => { 
        miGrafica.data.labels = response.labels;
        miGrafica.data.datasets[0].data = response.valores;
        miGrafica.update();
        document.getElementById('totalIncapacidades').textContent = response.numeroIncapacidades;
    };

    const solicitud = (type, data, url, funcion) => {
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
    }; 
</script>
<script>
    const hoy = new Date().toISOString().split('T')[0];

    document.getElementById('fecha_Inicio').value = hoy;
    document.getElementById('fecha_Fin').value = hoy;
</script>