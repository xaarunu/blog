<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notas Medicas de {{ date('Y') }}
        </h2>
    </x-slot>

    <x-boton-regresar />

  <div class="col-sm-12">
    @if ($hasNonZeroValues)
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 0px 50px 0px 50px;">
        <canvas id="myChart"></canvas>
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
<script src={{asset('plugins/chart/Chart.min.js')}}></script>
<script src={{asset('plugins/pikaday/pikaday.js')}}></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script> --}}

<script type="text/javascript">
  var labels = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ;
  var datos = <?php echo $saluds; ?>;
  console.log(datos);


  const data = {
    labels: labels,
    datasets: datos,
  };
//---------------------
  var stackedBarChartCanvas = $('#myChart').get(0).getContext('2d')
  var stackedBarChartData = $.extend(true, {}, data)

  var stackedBarChartOptions = {
    responsive: true,
    onClick: function(evt) {
      var activePoint = myChart.getElementAtEvent(evt)[0];
      var data = activePoint._chart.data;
      var datasetIndex = activePoint._datasetIndex;
      var labeldata = data.datasets[datasetIndex].label;
      var value = data.datasets[datasetIndex].data[activePoint._index];
      var label = this.data.labels[activePoint._index];
    },
    scales: {
      xAxes: [{
        stacked: true,
        ticks: {
          min: 0,
          max: <?php echo $maxNota ?>,
          stepSize: 1,
        }, scaleLabel: {
                display: true,
                labelString: 'Número de notas medicas', // Aquí puedes cambiar el nombre del eje X
            },
      }],
      yAxes: [{
        stacked: true,
            scaleLabel: {
                display: true,
                labelString: 'Meses', // Aquí puedes cambiar el nombre del eje Y
            },
      }],
    }
  }

  var config = {
    type: 'horizontalBar',
    data: stackedBarChartData,
    options: stackedBarChartOptions,
  };
  var myChart = new Chart(
    stackedBarChartCanvas,
    config
  );
</script>
