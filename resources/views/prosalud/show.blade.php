{{-- El Santo, el Cavernario, Blue Demond y el Buldog --}}
<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles') }}
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
    </style>
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">
    @endsection
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script> <!-- Localización en español -->
    @endsection
    <x-boton-regresar />
    <div class="mt-4 px-4 py-3 ml-11 leading-normal text-green-500 rounded-lg" role="alert">
        <div class="text-left">
          <div class="bg-white rounded-lg shadow-xl font-medium text-white px-4 py-2" style="width: 15%; right: 2%; position: absolute;">
            <div class="text-center text-gray-600">Guía de Colores</div>
            <div class="grid grid-cols-3 gap-2">
                <input style="background: #f0fa2d;"/>
                <input style="background: #4fda4f;"/>
                <input style="background: #fa2d2d;"/>
                <label class="text-center text-black">Bajo</label>
                <label class="text-center text-black">Normal</label>
                <label class="text-center text-black">Alto</label>
            </div>
        </div>
        </div>
      </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-5">
                <div class="col-sm-12">
                    @if ($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-12">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>
                <div  id="datos_usuario">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-8 mt-5 mb-2 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE:</label>
                            <input id="rpe" name="rpe" value="{{$expediente->rpe}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 border-green-600   mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
                            <input id="nombre" name="nombre" value="{{$expediente->nombre}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 border-green-600  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Toma:</label>
                            <input id="fecha_toma" name="fecha_toma" value="{{$expediente->fecha_toma}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 border-green-600  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                type="date" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Edad:</label>
                            <input id="edad" name="edad" value="{{$expediente->edad}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 border-green-600  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Glucosa: <br>  {{$expediente->glucosa_referencia}} </label>
                            <input id="glucosa_resultado" name="glucosa_resultado" value="{{$expediente->glucosa_resultado}} {{$expediente->glucosa_unidades}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 mt-1 focus:outline-none focus:ring-2 focus:ring- focus:border-transparent @if($expediente->glucosa_bajo) bg-yellow-300 @elseif ($expediente->glucosa_alto) bg-red-500 text-white @else bg-green-500 @endif "
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Trigliceridos: <br>  {{$expediente->trigliceridos_referencia}}</label>
                            <input id="trigliceridos_resultado" name="trigliceridos_resultado" value="{{$expediente->trigliceridos_resultado}} {{$expediente->trigliceridos_unidades}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 mt-1 focus:outline-none focus:ring-2 focus:ring- focus:border-transparent @if($expediente->trigliceridos_bajo) bg-yellow-300  @elseif ($expediente->trigliceridos_alto) bg-red-500  text-white @else bg-green-500 @endif "
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado del Colesterol: <br> {{$expediente->colesterol_referencia}}</label>
                            <input id="colesterol_resultado" name="colesterol_resultado" value="{{$expediente->colesterol_resultado}} {{$expediente->colesterol_unidades}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 mt-1 focus:outline-none focus:ring-2 focus:ring- focus:border-transparent @if($expediente->colesterol_bajo) bg-yellow-300 @elseif ($expediente->colesterol_alto) bg-red-500  text-white @else bg-green-500 @endif "
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de la Hemoglobina: <br> {{$expediente->hemoglobina_referencia}}</label>
                            <input id="hemoglobina_resultado" name="hemoglobina_resultado" value="{{$expediente->hemoglobina_resultado}} {{$expediente->hemoglobina_unidades}}" readonly
                            class="py-2 px-3 rounded-lg border-2  mt-1 focus:outline-none focus:ring-2 focus:ring- focus:border-transparent @if($expediente->hemoglobina_bajo) bg-yellow-300 @elseif ($expediente->hemoglobina_alto) bg-red-500 text-white @else bg-green-500 @endif "
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Leucocitos:<br>  {{$expediente->leucocitos_referencia}}</label>
                            <input id="leucocitos_resultado" name="leucocitos_resultado" value="{{$expediente->leucocitos_resultado}} {{$expediente->leucocitos_unidades}}"  readonly
                            class="py-2 px-3 rounded-lg border-2  mt-1 focus:outline-none focus:ring-2 focus:ring- focus:border-transparent @if($expediente->leucocitos_bajo) bg-yellow-300 @elseif ($expediente->leucocitos_alto) bg-red-500  text-white @else bg-green-500 @endif "
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Plaquetas:<br>  {{$expediente->plaquetas_referencia}}</label>
                            <input id="plaquetas_resultado" name="plaquetas_resultado" value="{{$expediente->plaquetas_resultado}} {{$expediente->plaquetas_unidades}}"  readonly
                            class="py-2 px-3 rounded-lg border-2  mt-1 focus:outline-none focus:ring-2 focus:ring- focus:border-transparent @if($expediente->plaquetas_bajo) bg-yellow-300 @elseif ($expediente->plaquetas_alto) bg-red-500 text-white @else bg-green-500 @endif"
                                type="text" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Zona:</label>
                            <input id="zona" name="zona" value="{{$expediente->area->area_nombre}}"  readonly
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                type="text" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


