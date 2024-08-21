<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exámenes') }}
        </h2>
    </x-slot>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .animacionOculto{
            transition: all 1s ease;
        }
    </style>
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">
    @endsection
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{asset('plugins/chart/AlterChart.min.js')}}"></script>
        <script src="{{asset('plugins/chart/DatalabelsChartPlugin.min.js')}}"></script>
    @endsection
    <x-boton-regresar />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gráfica con Chart.js</title>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </head>
        <section class="bg-white py-4 rounded-md border" style="min-height: 80vh">
            <div class="flex items-end justify-center mb-3">
                <div>
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                    <select id="optArea"
                        class="py-2 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @if($permisoTodas)
                            <option value="all">Todas las áreas</option>
                        @endif
                        @foreach($areas as $area)
                            @if ($area->division_id === 'DX' && $area->area_clave !== 'DXSU')
                                <option value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-9 gap-2 px-4 text-white font-bold my-5">
                <button  class="cursor-pointer text-sm whitespace-nowrap rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #0dcaab">
                    Notas Médicas
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #317ebd">
                    IMC
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #990155">
                    Incapacidades
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #f52116">
                    Glucosa
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #14cee3">
                    Trigliceridos
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #dba42c">
                    Colesterol
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #059c26">
                    Hemoglobina
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #a116fd">
                    Leucocitos
                </button>
                <button  class="cursor-pointer text-sm rounded-md flex justify-center gap-2 py-2 px-4" style="background-color: #c714be">
                    Plaquetas
                </button>
            </div>
            <div id="barraDeProgreso" class="w-full my-20 flex flex-col justify-center items-center gap-2">
                <img class=" w-32" src="{{ asset('img/comision.png') }}" alt="" />
                <div class="progressAnimationBar"></div>
            </div>
            <div class="py-12 w-4/5 mx-auto">
                <div id="contenidoPrincipal" class="max-w-7xl mx-auto sm:px-6 lg:px-8 opacity-0">
                    <p class="text-center">
                        Padecimientos Generales en Zona: <span id="zonaObjetivo">Todas</span>
                    </p>
                    <canvas id="graficaPersonales"></canvas> <!-- Aquí es donde se renderizará la gráfica -->
                </div>
            </div>
            <!--  -->
        </section>
        </html>
        </div>
    </div>
</x-app-layout>
<script>
    const csrfTokenElement = document.head.querySelector("[name~=csrf-token][content]");
    const csrfToken = csrfTokenElement ? csrfTokenElement.content : null;
    const SITEURL = "{{ url('/') }}";
    document.addEventListener('DOMContentLoaded', async() => {
        const optArea = document.querySelector("#optArea");
        optArea.addEventListener('change', filtrarPersonales);
        const graficaPersonales = crearGraficaPersonales();
        await filtrarPersonales();
    });


    const filtrarPersonales = async() => {
        agregarLoading();
        const area = document.querySelector('#optArea').value;
        const zonaObejtivo = document.querySelector('#zonaObjetivo');


        //var table = $('#data-table').DataTable();
        await fetch(SITEURL + '/estadistica/filtrarPersonales', {
            method: 'POST',
            body: JSON.stringify({
                area,
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
                return response.json();
        }).then(async(response) => {
            const {notas, imc, incapacidades, glucosa, trigliceridos, colesterol, hemoglobina, leucocitos, plaquetas, zona} = response;
            graficaPersonales.data.datasets[0].data = [notas, imc, incapacidades, glucosa, trigliceridos, colesterol, hemoglobina, leucocitos, plaquetas];
            graficaPersonales.options.plugins.title.text = 'Total de trabajadores: ' + response.total;

            zonaObejtivo.innerText = zona == 'all' ? 'Todas': zona.area_nombre;
            await graficaPersonales.update();
            removerLoading();
        }).catch(error => alert(error));
    }

    // Crear una nueva gráfica
    const crearGraficaPersonales = () => {
        const ctx = document.getElementById('graficaPersonales').getContext('2d');
        graficaPersonales = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Notas Médicas', 'IMC', 'Incapacidades',
                        'Glucosa',
                        'Trigliceridos',
                        'Colesterol',
                        'Hemoglobina',
                        'Leucocitos',
                        'Plaquetas'
                    ],
                datasets: [{
                    backgroundColor: [
                        'rgba(13, 202, 171, 0.8)',
                        'rgba(49, 126, 189, 0.8)',
                        'rgba(153, 1, 85, 0.8)',
                        'rgba(245, 33, 22, 0.8)',
                        'rgba(20, 206, 227, 0.8)',
                        'rgba(219, 164, 44, 0.8)',
                        'rgba(5, 156, 38, 0.8)',
                        'rgba(161, 22, 253, 0.8)',
                        'rgba(199, 20, 190, 0.8)'
                    ],
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
                        padding: {
                            bottom: 30,
                        }
                    },
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
                }
            },
            plugins: [ChartDataLabels]
        });

        return graficaPersonales;
    }


    const agregarLoading = () => {
        const barraDeProgreso = document.querySelector('#barraDeProgreso');
        const contenidoPrincipal = document.querySelector('#contenidoPrincipal');

        barraDeProgreso.classList.remove('hidden');
        contenidoPrincipal.classList.add('opacity-0');
        contenidoPrincipal.classList.remove('animacionOculto');
    }
    const removerLoading = () => {
        const barraDeProgreso = document.querySelector('#barraDeProgreso');
        const contenidoPrincipal = document.querySelector('#contenidoPrincipal');

        barraDeProgreso.classList.add('hidden');
        contenidoPrincipal.classList.remove('opacity-0');
        contenidoPrincipal.classList.add('animacionOculto');
    }

</script>

