<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prosalud Estadisticas
        </h2>
    </x-slot>

    <x-boton-regresar />

  <div class="col-sm-12">
    @if ($hasNonZeroValues)
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="width:80vw; margin:auto">
        <form class="w-full flex gap-2 justify-center mt-2" action="{{ route('prosalud.estadistica.zona') }}">
            <select class="rounded" name="zona">
                @foreach ($zonas as $zona)
                    <option {{ $zona == $zonaActual ? 'selected': '' }} value="{{ $zona }}">{{ $zona == 'Oficionas Divisional' ? 'Oficinas Divisional': $zona }}</option>
                @endforeach
            </select>
            <button class="text-white bg-green-600 px-4 rounded-md">
                Filtrar
            </button>
        </form>
        <canvas class="p-10" id="chartBajos"></canvas>
        <canvas class="p-10" id="chartMedio"></canvas>
        <canvas class="p-10" id="chartAltos"></canvas>
      </div>
    @else
      <div class="alert" style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
        <p>No hay datos disponibles para mostrar en la gráfica.</p>
    </div>
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 0px 50px 0px 50px;">
        <canvas id="myChart"></canvas>
      </div>
    @endif
  </div>
</x-app-layout>

<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<link rel="stylesheet" type="text/css" href={{asset('plugins/pikaday/pikaday.css')}}>
<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>
<script src={{asset('plugins/chart/AlterChart.min.js')}}></script>
<script src={{asset('plugins/chart/DatalabelsChartPlugin.min.js')}}></script>
<script src={{asset('plugins/pikaday/pikaday.js')}}></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script> --}}

<script type="text/javascript">

    const ctxBajos = document.getElementById('chartBajos');
    const ctxMedio = document.getElementById('chartMedio');
    const ctxAltos = document.getElementById('chartAltos');

    const bajos = {!! json_encode($bajos) !!}
    const normal = {!! json_encode($normal) !!}
    const altos = {!! json_encode($altos) !!}

    new Chart(ctxBajos, {
      type: 'bar',
      data: {
        labels: [
            'Glucosa',
            'Trigliceridos',
            'Colesterol',
            'Hemoglobina',
            'Leucocitos',
            'Plaquetas'
        ],
        datasets: [{
          label: 'Bajos',
          data: bajos,
          backgroundColor: ['#f52116', '#14cee3', '#dba42c', '#329c05', '#8717d1', '#c714be'],
          borderWidth: 1
        }]
      },
      options: {
        plugins:{
          datalabels: {
            anchor: 'end',
            align: 'top',
            formatter: (value, context) => value,
            font: {
              weight: 'bold'
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
    new Chart(ctxMedio, {
      type: 'bar',
      data: {
        labels: [
            'Glucosa',
            'Trigliceridos',
            'Colesterol',
            'Hemoglobina',
            'Leucocitos',
            'Plaquetas'
        ],
        datasets: [{
          label: 'Normal',
          data: normal,
          backgroundColor: ['#f52116', '#14cee3', '#dba42c', '#329c05', '#8717d1', '#c714be'],
          borderWidth: 1
        }]
      },
      options: {
        plugins:{
          datalabels: {
            anchor: 'end',
            align: 'top',
            formatter: (value, context) => value,
            font: {
              weight: 'bold'
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
    new Chart(ctxAltos, {
      type: 'bar',
      data: {
        labels: [
            'Glucosa',
            'Trigliceridos',
            'Colesterol',
            'Hemoglobina',
            'Leucocitos',
            'Plaquetas'
        ],
        datasets: [{
          label: 'Altos',
          data: altos,
          backgroundColor: ['#f52116', '#14cee3', '#dba42c', '#329c05', '#8717d1', '#c714be'],
          borderWidth: 1
        }]
      },
      options: {
        plugins:{
          datalabels: {
            anchor: 'end',
            align: 'top',
            formatter: (value, context) => value,
            font: {
              weight: 'bold'
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
</script>
