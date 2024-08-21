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
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin:auto">
        <h2 class="text-lg font-bold text-center mt-2">
            {{ $dato }}
        </h2>
        <form class="w-full flex gap-2 justify-center mt-2" action="{{ route('prosalud.estadistica.estadisticaDato') }}">
            <select class="rounded" name="dato">
                <option value="Glucosa" {{ $dato == 'Glocusa' ? 'selected': '' }}>Glucosa</option>
                <option value="Trigliceridos" {{ $dato == 'Trigliceridos' ? 'selected': '' }}>Trigliceridos</option>
                <option value="Colesterol" {{ $dato == 'Colesterol' ? 'selected': '' }}>Colesterol</option>
                <option value="Hemoglobina" {{ $dato == 'Hemoglobina' ? 'selected': '' }}>Hemoglobina</option>
                <option value="Leucocitos" {{ $dato == 'Leucocitos' ? 'selected': '' }}>Leucocitos</option>
                <option value="Plaquetas" {{ $dato == 'Plaquetas' ? 'selected': '' }}>Plaquetas</option>
            </select>
            <button class="text-white bg-green-600 px-4 rounded-md">
                Filtrar
            </button>
        </form>
        <div class="w-1/3 mx-auto">
            <canvas class="p-10" id="myChart"></canvas>
        </div>
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
<script src={{asset('plugins/chart/Chart.min.js')}}></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script> --}}

<script type="text/javascript">
    const ctx = document.getElementById('myChart').getContext('2d');

    const data = {!! json_encode($resultado) !!};

    new Chart(ctx, {
    type: 'pie',
    data: {
            labels: ['Bajo', 'Normal', 'Alto'],
            datasets: [{
                data: data,
                backgroundColor: ['#f52116', '#14cee3', '#e3dc14'],
            }]
        }
    });
</script>
