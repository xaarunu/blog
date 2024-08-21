<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prosalud Estadisticas
        </h2>
    </x-slot>

    <style>
        #formatoActual{
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>

    <x-boton-regresar />


    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">

    @if ($permisos)
        <div
            id="modalPadecimientos"
            class="fixed w-full overflow-auto inset-0 hidden" style="height: calc(100% - 5rem); margin: 5rem 0; background-color: rgb(75 85 99 / 0.6);"
        >
            <div
                id="modalPadecimientosFondo"
                class="h-full w-full flex justify-between items-start gap-10 pt-10 pr-32 pl-10"
            >
                <div class="flex flex-col items-center w-2/6 bg-white rounded-md p-4 shadow-md border border-black" style="max-height: 70%">
                    <h2 class="text-green-500 text-2xl">
                        <span id="nombreDato">Nombre Dato</span> - Nivel {{ ucfirst($tipo) }}
                    </h2>
                    <div class="flex justify-center items-center gap-4">
                        <p class="m-0 text-lg">
                        Trabajores:
                        <span id="indiceDato" class="font-bold text-lg">Indice</span>
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 mt-3 w-full text-gray-600 font-semibold">
                        <div class="w-full flex justify-between px-16">
                            <p>Zonas</p>
                            <p>Total</p>
                        </div>
                    </div>
                    <div id="zonasResultado" class="flex flex-col gap-2 mt-3 w-full text-gray-600 font-semibold overflow-y-auto" style="max-height: 100%">
                        {{-- <div class="w-full flex justify-between px-16">
                            <p>Zonas</p>
                            <p>Numero de usuarios</p>
                        </div> --}}
                    </div>
                </div>
                <div class="flex-1 bg-white rounded-lg border border-black p-4" style="max-height: 100%">
                    <table id="tablaPadecimientos" class="display w-full h-full">
                        <thead>
                            <tr class="text-center border-b border-b-gray-100">
                                <th class="py-4 font-bold text-gray-500">
                                    RPE
                                </th>
                                <th class="py-4 font-bold text-gray-500">
                                    Nombre
                                </th>
                                <th class="py-4 font-bold text-gray-500">
                                    Resultado <span id="datoObjetivoColumna"></span>
                                </th>
                                <th class="py-4 font-bold text-gray-500">
                                    Referencia <span id="datoReferenciaColumna"></span>
                                </th>
                                <th class="py-4 font-bold text-gray-500">
                                    Zona
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
            </div>
            <p
                id="cerrarPadecimientosModal"
                class="text-3xl font-bold cursor-pointer absolute top-10 right-16 rounded-full bg-white h-10 w-10 flex items-center justify-center pb-1">
                x
            </p>
        </div>


        <div
            id="modalTrabajadores"
            class="fixed w-full overflow-auto inset-0 hidden z-50" style="height: calc(100% - 5rem); margin: 5rem 0; background-color: rgb(75 85 99 / 0.6);"
        >
            <div
                id="modalTrabajadoresFondo"
                class="h-full w-full flex justify-between items-start gap-10 pt-10 pr-32 pl-10"
            >
                <div class="flex-1 bg-white rounded-lg border border-black p-4" style="max-height: 100%">
                    <div id="divTablaTrabajadores" class="w-full">
                        <table id="tablaTrabajadores" class="display w-full" style="width: 100% !important">
                            <thead>
                                <tr class="text-center border-b border-b-gray-100">
                                    <th class="py-4 font-bold text-gray-500">
                                        Area
                                    </th>
                                    <th class="py-4 font-bold text-gray-500">
                                        RPE
                                    </th>
                                    <th class="py-4 font-bold text-gray-500">
                                        Nombre
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                    {{-- <div id="divTablaTrabajadoresNo" class="w-full hidden">
                        <table id="tablaTrabajadoresNo" class="display w-full" style="width: 100% !important">
                            <thead>
                                <tr class="text-center border-b border-b-gray-100">
                                    <th class="py-4 font-bold text-gray-500">
                                        Area
                                    </th>
                                    <th class="py-4 font-bold text-gray-500">
                                        RPE
                                    </th>
                                    <th class="py-4 font-bold text-gray-500">
                                        Cita
                                    </th>
                                    <th class="py-4 font-bold text-gray-500">
                                        Nombre
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
            <p
                id="cerrarTrabajadoresModal"
                class="text-3xl font-bold cursor-pointer absolute top-10 right-16 rounded-full bg-white h-10 w-10 flex items-center justify-center pb-1">
                x
            </p>
        </div>
    @endif

  <div class="col-sm-12">
    @if ($hasNonZeroValues)
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mx-auto my-6" style="width:90%;">
        @if (!$permisos)
            <p class="font-bold text-2xl text-gray-600 text-center">
                {{ $zonaObjetivo }}
            </p>
        @endif
        <form class="w-full flex gap-2 justify-center items-center mt-2" action="{{ route('prosalud.estadistica.general') }}">
            @if ($permisos)
                <select class="rounded" name="zona">
                    <option value="">Todas las Zonas</option>
                    @foreach ($zonas as $clave => $zona)
                        <option value="{{$clave}}" {{ $zonaObjetivo == $clave ? 'selected': '' }}>{{ $zona }}</option>
                    @endforeach
                </select>
            @endif
            <select class="rounded" name="tipo">
                <option value="bajo" {{ $tipo == 'bajo' ? 'selected': '' }}>Indice Bajo</option>
                <option value="normal" {{ $tipo == 'normal' ? 'selected': '' }}>Indice Normal</option>
                <option value="alto" {{ $tipo == 'alto' ? 'selected': '' }}>Indice Alto</option>
            </select>
            <select class="rounded" name="fecha">
                @foreach ($fechas as $fecha)
                    <option value="{{ $fecha }}" {{ $fechaObjetivo == $fecha ? 'selected': '' }}>{{ $fecha }}</option>
                @endforeach
            </select>
            <button class="text-white bg-green-600 px-4 py-2 rounded-md">
                Filtrar
            </button>
        </form>
        <div class="flex justify-center gap-2 px-4 text-white font-bold my-5">
            <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato'=>'glucosa']) }}" class="cursor-pointer flex justify-center gap-2 py-2 px-4" style="background-color: #f52116">
                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Glucosa
            </a>
            <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato'=>'trigliceridos']) }}" class="cursor-pointer flex justify-center gap-2 py-2 px-4" style="background-color: #14cee3">
                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Trigliceridos
            </a>
            <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato'=>'colesterol']) }}" class="cursor-pointer flex justify-center gap-2 py-2 px-4" style="background-color: #dba42c">
                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Colesterol
            </a>
            <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato'=>'hemoglobina']) }}" class="cursor-pointer flex justify-center gap-2 py-2 px-4" style="background-color: #329c05;">
                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Hemoglobina
            </a>
            <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato'=>'leucocitos']) }}" class="cursor-pointer flex justify-center gap-2 py-2 px-4" style="background-color: #8717d1;">
                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Leucocitos
            </a>
            <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato'=>'plaquetas']) }}" class="cursor-pointer flex justify-center gap-2 py-2 px-4" style="background-color: #c714be;">
                <svg class="w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Plaquetas
            </a>
        </div>
        <div id="barraDeProgreso" class="w-full my-20 flex flex-col justify-center items-center gap-2">
            <img class=" w-32" src="{{ asset('img/comision.png') }}" alt="" />
            <div class="progressAnimationBar"></div>
        </div>
        <div id="contenidoPrincipal" class="hidden">
            <div class="flex justify-center gap-2 w-full mt-10" style="color: #696969;">
                @if ($permisos)
                    <button id="btnMostrarTrabajadores" class="text-lg select-none bg-green-600 text-white px-4 py-2 rounded-md flex gap-3 items-center cursor-pointer">
                        <svg class="w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <p class="text-lg select-none bg-green-600 text-white px-4 py-2 rounded-md flex gap-3 items-center">
                            <span class="font-bold">Total Trabajadores: </span>{{ $totalTrabajadores->count() }} / <span id="totalExmanes">0</span>
                        </p>
                    </button>
                @else
                    <p class="text-lg select-none bg-green-600 text-white px-4 py-2 rounded-md flex gap-3 items-center">
                        <span class="font-bold">Total Trabajadores: </span>{{ $totalTrabajadores->count() }} / <span id="totalExmanes">0</span>
                    </p>
                @endif
            </div>
            <div class="flex justify-center gap-2 w-full mt-10" style="color: #696969;">
                <span class="font-bold">Indice: </span>{{ ucfirst($tipo) }} </span>
            </div>
            @if ($permisos)
                <div class="flex justify-center gap-2 w-full mt-10" style="color: #696969;">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#696969"><path d="M419-80q-28 0-52.5-12T325-126L107-403l19-20q20-21 48-25t52 11l74 45v-328q0-17 11.5-28.5T340-760q17 0 29 11.5t12 28.5v472l-97-60 104 133q6 7 14 11t17 4h221q33 0 56.5-23.5T720-240v-160q0-17-11.5-28.5T680-440H461v-80h219q50 0 85 35t35 85v160q0 66-47 113T640-80H419ZM167-620q-13-22-20-47.5t-7-52.5q0-83 58.5-141.5T340-920q83 0 141.5 58.5T540-720q0 27-7 52.5T513-620l-69-40q8-14 12-28.5t4-31.5q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 17 4 31.5t12 28.5l-69 40Zm335 280Z"/></svg>
                <p class="m-0 italic">Seleccione una barra para ver los pacientes</p>
                </div>
            @endif
            <div class="flex justify-end w-full pr-10" style="color: #1b5fac">
                <div id="btnFormato" class="flex gap-2 cursor-pointer">
                    <p id="formatoActual" class="m-0 italic">Númerico</p>
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                    </svg>
                </div>
            </div>
            <div class="grid grid-cols-3">
                <div class="col-span-3 w-3/4 mx-auto">
                    <canvas class="p-2 mb-10 w-full" id="padecimientoChart"></canvas>
                </div>
                <div class="mt-4 hidden">
                    <canvas class="p-2 mb-10 w-full" id="trabajadoresChart"></canvas>
                </div>
            </div>
        </div>
      </div>
    @else
      <div class="alert font-bold" style="color: #ffffff; background-color: #f87171; border: 1px solid #ffffff; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
        <p>No hay datos disponibles para mostrar en la gráfica.</p>
      </div>
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-auto py-10 mb-4" style="padding: 0px 0px 0px 50px;  width: 90%;">
        <form class="w-full flex gap-2 justify-center mt-2" action="{{ route('prosalud.estadistica.general') }}">
            @if (Auth::user()->hasAnyRole(['admin', 'Doctora']))
                <select class="rounded" name="zona">
                    <option value="">Todas las Zonas</option>
                    @foreach ($zonas as $clave => $zona)
                        <option value="{{$clave}}" {{ $zonaObjetivo == $clave ? 'selected': '' }}>{{ $zona }}</option>
                    @endforeach
                </select>
            @else

            @endif
            <select class="rounded" name="tipo">
                <option value="bajo" {{ $tipo == 'bajo' ? 'selected': '' }}>Indice Bajo</option>
                <option value="normal" {{ $tipo == 'normal' ? 'selected': '' }}>Indice Normal</option>
                <option value="alto" {{ $tipo == 'alto' ? 'selected': '' }}>Indice Alto</option>
            </select>
            <select class="rounded" name="fecha">
                @foreach ($fechas as $fecha)
                    <option value="{{ $fecha }}" {{ $fechaObjetivo == $fecha ? 'selected': '' }}>{{ $fecha }}</option>
                @endforeach
            </select>
            <button class="text-white bg-green-600 px-4 rounded-md">
                Filtrar
            </button>
        </form>
        <div class="grid grid-cols-2" style="min-height: 90vh;">
            <canvas class="p-2 mb-10 w-full" id="padecimientoChart"></canvas>
            <canvas class="p-2 mb-10 w-full" id="trabajadoresChart"></canvas>
        </div>
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
<script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script> --}}

<script type="text/javascript">

    const tipoIndice = {!! json_encode($tipo) !!}
    const data = {!! json_encode($resultado) !!};

    const resultadoZonas = {!! json_encode($resultadoZonas) !!}

    const nombresZonas = {!! json_encode($zonas) !!}

    const totalTrabajadores = {!! json_encode($totalTrabajadores) !!}

    const totalTrabajadoresZonas = {!! json_encode($totalTrabajadoresZonas) !!}

    const totalUsuariosExamenZona = totalTrabajadoresZonas.filter(x => (totalTrabajadores.find(y => y.rpe == x.rpe) != null) );

    const totalExamenesRealizados = totalTrabajadores.length - totalUsuariosExamenZona.length + totalTrabajadoresZonas.length;

    const totalExmanes = document.querySelector('#totalExmanes');
    totalExmanes.innerText = totalExamenesRealizados;

    // console.log(totalUsuariosExamenZona);


    // console.log(totalTrabajadoresZonas.filter(x => x.area == 'DX00'));


    // console.log(totalTrabajadoresZonas.filter(x => (totalTrabajadores.find(y => y.rpe == x.rpe) == null) ));
    // let i = 1;
    // totalTrabajadoresZonas.filter(x => (totalTrabajadores.find(y => y.rpe == x.rpe && console.log(x.rpe, y.rpe, i++)) == null));


    const permisos = {!! json_encode($permisos) !!}



    const chartPacientes = {
        numerica: null,
        porcentaje: null,
        total: () => {
            let countDatos = 0;
            for(let datoTmp in data){
                countDatos += data[datoTmp];
            }
            return countDatos;
        }
    };
    const chartTrabajadores = {
        numerica: null,
        porcentaje: null,
        total: () => {
            return totalExamenesRealizados;
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        removerLoading();
        try {
            ocultarModalPadecimientosConfig();
            ocultarModalTrabajadoresConfig();
            crearGraficaPadecimientosNumerica();
            crearGraficaTrabajadoresNumerica();
            switchFormatoConfig();
        } catch (error) {
            crearGraficaPadecimientosNumerica();
            crearGraficaTrabajadoresNumerica();
            switchFormatoConfig();
        }
    });

    const removerLoading = () => {
        const barraDeProgreso = document.querySelector('#barraDeProgreso');
        const contenidoPrincipal = document.querySelector('#contenidoPrincipal');

        barraDeProgreso.remove();
        contenidoPrincipal.classList.remove('hidden');
    }

    const crearGraficaPadecimientosNumerica = (zona) => {

      crearGraficaPadecimientos(false, data);

    }

    const crearGraficaPadecimientosPorcentaje = (zona) => {

      const datosNumericos = [];
      let total = 0;
      for(let datoTmp in data){
        total += data[datoTmp];
      }
      for(let datoTmp in data){
        const porcentaje = data[datoTmp] * 100 / total;
        datosNumericos.push(porcentaje != 0 ? porcentaje.toFixed(0): porcentaje);
      }
      crearGraficaPadecimientos(true, datosNumericos);
    }

    const crearGraficaPadecimientos = (porcentaje, dataset) => {
        const ctx = document.getElementById('padecimientoChart');
        let tipo = porcentaje ? 'porcentaje': 'numerica';

        chartPacientes[tipo] = new Chart(ctx, {
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
                data: dataset,
                backgroundColor: ['#f52116', '#14cee3', '#dba42c', '#329c05', '#8717d1', '#c714be'],
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
                        text: 'Total Padecimientos: ' + chartPacientes.total(),
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
                    formatter: (value, context) => porcentaje ? value + '%': value,
                    font: {
                        weight: 'bold'
                    }
                    }
                },
                onClick: (event, elements) => {
                    if(!permisos) return;

                    try {
                    const [{index: index}] = elements;
                    const cantidad = elements[0].element.$context.raw;

                    let zonasDato = null;
                    switch (index) {
                        case 0:
                        abrirPadecimientosModal();
                        zonasDato = resultadoZonas['Glucosa'];
                        mostrarInfoModal("Glucosa", cantidad, zonasDato, porcentaje, data[0]);
                        break;
                        case 1:
                        abrirPadecimientosModal();
                        zonasDato = resultadoZonas['Trigliceridos'];
                        mostrarInfoModal("Trigliceridos", cantidad, zonasDato, porcentaje, data[1]);
                        break;
                        case 2:
                        abrirPadecimientosModal();
                        zonasDato = resultadoZonas['Colesterol'];
                        mostrarInfoModal("Colesterol", cantidad, zonasDato, porcentaje, data[2]);
                        break;
                        case 3:
                        abrirPadecimientosModal();
                        zonasDato = resultadoZonas['Hemoglobina'];
                        mostrarInfoModal("Hemoglobina", cantidad, zonasDato, porcentaje, data[3]);
                        break;
                        case 4:
                        abrirPadecimientosModal();
                        zonasDato = resultadoZonas['Leucocitos'];
                        mostrarInfoModal("Leucocitos", cantidad, zonasDato, porcentaje, data[4]);
                        break;
                        case 5:
                        abrirPadecimientosModal();
                        zonasDato = resultadoZonas['Plaquetas'];
                        mostrarInfoModal("Plaquetas", cantidad, zonasDato, porcentaje, data[5]);
                        break;
                        default:
                        break;
                    }
                    } catch (error) {

                    }
                },
                onHover: (event, chartElement) => {
                    if(!permisos) return;
                    event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                },
                scales: {
                    y: {
                    beginAtZero: true
                    }
                },
            },
            plugins: [ChartDataLabels]
        });
    }


    const crearGraficaTrabajadoresNumerica = (zona) => {

        crearGraficaTrabajadores(false, [totalTrabajadores.length, totalExamenesRealizados - totalTrabajadores.length]);

    }

    const crearGraficaTrabajadoresPorcentaje = (zona) => {
        const datosNumericos = [totalTrabajadores.length, totalExamenesRealizados - totalTrabajadores.length];
        const conExamen = (datosNumericos[0] * 100 / totalExamenesRealizados).toFixed(0);
        const sinExamen = (datosNumericos[1] * 100 / totalExamenesRealizados).toFixed(0);
        crearGraficaTrabajadores(true, [conExamen, sinExamen]);
    }


    const crearGraficaTrabajadores = (porcentaje, dataset) => {
        const ctx = document.getElementById('trabajadoresChart');
        let tipo = porcentaje ? 'porcentaje': 'numerica';

        chartTrabajadores[tipo] = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: [
                'Si',
                'No'
            ],
            datasets: [{
                data: dataset,
                backgroundColor: ['rgb(71 218 255 / 0.5)', 'rgb(75 85 99 / 0.4)'],
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
                        text: 'Total trabajadores con indice '+tipoIndice+ ': ' + totalExamenesRealizados,
                        font: {
                        size: 15,
                        },
                        padding: {
                            bottom: 30,
                        }
                    },
                    datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: (value, context) => porcentaje ? value + '%': value,
                    font: {
                        weight: 'bold'
                    }
                    }
                },
                /*
                onClick: (event, elements) => {
                    if(!permisos) return;

                    try {
                    const [{index: index}] = elements;
                    const cantidad = elements[0].element.$context.raw;

                    let zonasDato = null;
                    switch (index) {
                        case 0:
                            mostrarTablaTrabajadores('divTablaTrabajadores');
                            abrirTrabajadoresModal();
                            break;
                        case 1:
                            mostrarTablaTrabajadores('divTablaTrabajadoresNo');
                            abrirTrabajadoresModal();
                            break;
                        default:
                        break;
                    }
                    } catch (error) {

                    }
                },

                onHover: (event, chartElement) => {
                    if(!permisos) return;
                    event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                },
                */
                scales: {
                    y: {
                    beginAtZero: true
                    }
                },
            },
            plugins: [ChartDataLabels]
        });
    }

    // const mostrarTablaTrabajadores = (idTablaObjetivo) => {
    //     const divTablaTrabajadores = document.querySelector('#divTablaTrabajadores');
    //     const divTablaTrabajadoresNo = document.querySelector('#divTablaTrabajadoresNo');
    //     divTablaTrabajadores.classList.add('hidden');
    //     divTablaTrabajadoresNo.classList.add('hidden');
    //     if(idTablaObjetivo === 'divTablaTrabajadores'){
    //         divTablaTrabajadores.classList.remove('hidden');
    //     }else{
    //         divTablaTrabajadoresNo.classList.remove('hidden');
    //     }
    // }

    const tablaPadecimientos = new DataTable('#tablaPadecimientos', {
        scrollCollapse: true,
        scrollY: '40vh',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
    });

    const tablaTrabajadores = new DataTable('#tablaTrabajadores', {
        scrollY: '50vh',
        data: totalTrabajadores,
        columns: [
            {
                data: 'area',
                render: (data) => {
                    return nombresZonas[data];
                }
            },
            {
                data: 'rpe',
                render: function(data, type, row) {
                    return data ? data : '------';
                }
            },
            { data: 'nombre' },
        ],
        columnDefs: [
            { width: '20%', targets: 0 },
            { width: '20%', targets: 1 },
            { width: '60%', targets: 2 },
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        autoWidth: false,
        initComplete: () =>{
            const tablaTrabajadores_wrapper = document.querySelector('#tablaTrabajadores_wrapper');
            const dataTables_scrollHeadInner = tablaTrabajadores_wrapper.querySelector('.dataTables_scrollHeadInner');
            const header = dataTables_scrollHeadInner.querySelector('table');
            dataTables_scrollHeadInner.style.width = '100%';
            header.style.width = '100%';

        }
    });

    const tablaTrabajadoresNo = new DataTable('#tablaTrabajadoresNo', {
        scrollY: '50vh',
        data: totalTrabajadoresZonas.filter(x => (totalTrabajadores.find(y => y.rpe == x.rpe) == null) ),
        columns: [
            {
                data: 'rpe',
                render: function(data, type, row) {
                    return data ? data : '------';
                }
            },
            {
                data: 'area',
                render: (data) => {
                    return nombresZonas[data];
                }
            },
            {
                render: (data) => {
                    return `<button class='px-4 py-2 bg-yellow-500 text-white font-bold rounded'>Agendar Cita</button>`;
                }
            },
            { data: 'nombre' },
        ],
        columnDefs: [
            { width: '20%', targets: 0 },
            { width: '20%', targets: 1 },
            { width: '20%', targets: 2 },
            { width: '40%', targets: 3 },
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        autoWidth: false,
        initComplete: () =>{
            const tablaTrabajadores_wrapper = document.querySelector('#tablaTrabajadoresNo_wrapper');
            const dataTables_scrollHeadInner = tablaTrabajadores_wrapper.querySelector('.dataTables_scrollHeadInner');
            const header = dataTables_scrollHeadInner.querySelector('table');
            dataTables_scrollHeadInner.style.width = '100%';
            header.style.width = '100%';

        }
    });

    const mostrarInfoModal = (dato, cantidad, zonas, porcentaje, total) => {

      const nombreDato = document.querySelector('#nombreDato');
      const indiceDato = document.querySelector('#indiceDato');
      const datoObjetivoColumna = document.querySelector('#datoObjetivoColumna');
      const datoReferenciaColumna = document.querySelector('#datoReferenciaColumna');
      nombreDato.innerText = dato;
      indiceDato.innerText = porcentaje ? cantidad + '%' : cantidad;
      datoObjetivoColumna.innerText = dato;
      datoReferenciaColumna.innerText = dato;

      formatearInfoModalZonas(zonas, porcentaje ? total: null);
      llenarDataTable(dato, zonas);

    }

    const llenarDataTable = (dato, zonas) => {
      tablaPadecimientos.clear();
      const dato_referencia = dato.toLowerCase() + '_referencia';
      const dato_resultado = dato.toLowerCase() + '_resultado';


      for(let zona in zonas){
        const zonaTmp = zonas[zona];
        zonaTmp.forEach(usuario => {
          tablaPadecimientos.row.add([
            usuario.rpe == '' ? '-----': usuario.rpe,
            usuario.nombre,
            usuario[dato_resultado],
            usuario[dato_referencia],
            nombresZonas[usuario.zona],
          ]);
        });
      }

      tablaPadecimientos.draw();
    }

    const formatearInfoModalZonas = (zonas, porcentaje) => {
      const listaZonas = document.querySelector('#zonasResultado');
      listaZonas.innerHTML = '';
      if(porcentaje!=null){
        for(let zona in zonas){
            const zonaTmp = zonas[zona];
            let countZona = 0;
            zonaTmp.forEach(usuario => {
                countZona++;
            });


            const porcentajeTmp = (countZona * 100 / porcentaje).toFixed(0);

            listaZonas.innerHTML += `<div class="w-full flex justify-between px-8">
                            <p>${nombresZonas[zona]}</p>
                            <p>${porcentajeTmp} %</p>
                        </div>`;
        }
      }else{
        for(let zona in zonas){
            const zonaTmp = zonas[zona];
            let countZona = 0;
            zonaTmp.forEach(usuario => {
                countZona++;
            });

            listaZonas.innerHTML += `<div class="w-full flex justify-between px-8">
                            <p>${nombresZonas[zona]}</p>
                            <p>${countZona}</p>
                        </div>`
        }
      }
    }

    const ocultarModalPadecimientosConfig = () => {
      const modalPadecimientos = document.querySelector('#modalPadecimientos');
      const cerrarPadecimientosModal = document.querySelector('#cerrarPadecimientosModal');
      modalPadecimientos.addEventListener('click', (e) => {
          if(e.target.getAttribute('id') == 'modalPadecimientosFondo'){
              ocultarPadecimientosModal();
          }
      });
      cerrarPadecimientosModal.addEventListener('click', () => {
          ocultarPadecimientosModal();
      });
    }

    const ocultarPadecimientosModal = () => {
        const modal = document.querySelector('#modalPadecimientos');
        modal.classList.add('hidden');
    }

    const abrirPadecimientosModal = () => {
        const modal = document.querySelector('#modalPadecimientos');
        modal.classList.remove('hidden');
    }

    const ocultarModalTrabajadoresConfig = () => {
        const btnMostrarTrabajadores = document.querySelector('#btnMostrarTrabajadores');
        const modalTrabajadores = document.querySelector('#modalTrabajadores');
        const cerrarTrabajadoresModal = document.querySelector('#cerrarTrabajadoresModal');
        modalTrabajadores.addEventListener('click', (e) => {
            if(e.target.getAttribute('id') == 'modalTrabajadoresFondo'){
                ocultarTrabajadoresModal();
            }
        });
        cerrarTrabajadoresModal.addEventListener('click', () => {
            ocultarTrabajadoresModal();
        });
        btnMostrarTrabajadores.addEventListener('click', () => {
            abrirTrabajadoresModal();
        })
    }

    const ocultarTrabajadoresModal = () => {
        const modal = document.querySelector('#modalTrabajadores');
        document.querySelector('body').classList.remove('overflow-hidden');
        modal.classList.add('hidden');
    }

    const abrirTrabajadoresModal = () => {
        const modal = document.querySelector('#modalTrabajadores');
        document.querySelector('body').classList.add('overflow-hidden');
        modal.classList.remove('hidden');
    }

    const switchFormatoConfig = () => {
        const btnFormato = document.querySelector('#btnFormato');
        const formatoActual = document.querySelector('#formatoActual');

        btnFormato.addEventListener('click', () => {
            if(formatoActual.innerText == 'Númerico'){
                formatoActual.innerText = 'Porcentaje';
                chartPacientes.numerica.destroy();
                chartTrabajadores.numerica.destroy();
                crearGraficaPadecimientosPorcentaje();
                crearGraficaTrabajadoresPorcentaje();
            }else{
                formatoActual.innerText = 'Númerico';
                chartPacientes.porcentaje.destroy();
                chartTrabajadores.porcentaje.destroy();
                crearGraficaPadecimientosNumerica();
                crearGraficaTrabajadoresNumerica();
            }
        });
    }

</script>
