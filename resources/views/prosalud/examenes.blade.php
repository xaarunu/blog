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
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-white rounded-md p-4">
                <div class="flex items-end justify-center mb-3">
                    <div class="mr-4">
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

                    <div class="mr-4">
                        <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold" for="year">Año:</label>
                        <select id="year"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" style="width: 150px; ">
                            @foreach ($fechas as $fecha)
                                <option value="{{ $fecha }}">{{ $fecha }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="barraDeProgreso" class="w-full my-20 flex flex-col justify-center items-center gap-2">
                    <img class=" w-32" src="{{ asset('img/comision.png') }}" alt="" />
                    <div class="progressAnimationBar"></div>
                </div>
                <div class="py-12">
                    <div id="contenidoPrincipal" class="max-w-7xl mx-auto sm:px-6 lg:px-8 opacity-0">
                        <canvas id="graficaExamenes"></canvas> <!-- Aquí es donde se renderizará la gráfica -->
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
        optArea.addEventListener("change", filtrarExamenes);
        const year = document.querySelector("#year");
        year.addEventListener("change", filtrarExamenes);
        const graficaExamenes = crearGraficaExamenes();
        await filtrarExamenes();
    });


    const filtrarExamenes = async() => {
        agregarLoading();
        const area = document.querySelector('#optArea').value;
        const year = document.querySelector("#year").value;


        //var table = $('#data-table').DataTable();
        await fetch(SITEURL + '/prosalud/filtrarExamenes', {
            method: 'POST',
            body: JSON.stringify({
                area,
                year,
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

            graficaExamenes.data.datasets[0].data = [response.usuariosConExamen.length, response.usuariosSinExamen.length];
            graficaExamenes.options.plugins.title.text = 'Total de trabajadores: ' + response.total;
            await graficaExamenes.update();
            removerLoading();
        }).catch(error => alert(error));
    }

    // Crear una nueva gráfica
    const crearGraficaExamenes = () => {
        const ctx = document.getElementById('graficaExamenes').getContext('2d');
        graficaExamenes = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Examenes Realizados', 'Sin Examen'],
                datasets: [{
                    backgroundColor: [
                        'rgba(82, 255, 108, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(10, 171, 34, 1)',
                        'rgba(255, 159, 64, 1)',
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

        return graficaExamenes;
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

