<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mostrar Incapacidad') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    @endsection

    @if(session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="py-12">
        <x-boton-regresar />
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <form class="formEnviar w-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8 mt-3 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE:</label>
                        <input readonly id="rpe" value="{{$datosuser->rpe}}" type="text" maxlength="5" minlength="5"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
                        <input readonly minlength="5" id='solicitante' value="{{$nombre}}" type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">No. Certificado:</label>
                        <input readonly maxlength="12" value="{{$incapacidad->certificado}}" minlength="8" name="certificado" id='certificado' type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Unidad Médica:</label>
                        <input type="text" name="unidad_medica" id="unidad_medica" value="{{ $incapacidad->umf ? $incapacidad->umf->nombre : 'No registrada' }}"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Consultorio:</label>
                        <input name="consultorio" id="consultorio" type="text" value="{{ $incapacidad->consultorio ?? 'No registrada' }}"
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
                    </div>

                    <div class="grid grid-cols-1">
                        <label for="turno" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Turno:</label>
                        <input name="turno" id="turno" type="text" value="{{ $incapacidad->turno ? ucfirst($incapacidad->turno) : 'No registrada' }}"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Tipo de Incapacidad:</label>
                        <select name="tipo" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text"/>
                            <option disabled selected> {{ $incapacidad->tipo }}</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha inicio:</label>
                        <input id="fecha_inicio" type="date" value="{{$incapacidad->fecha_inicio}}" name="fecha_inicio" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" readonly/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha fin:</label>
                        <input id="fecha_fin" type="date" value="{{$incapacidad->fecha_fin}}" name="fecha_fin" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" readonly/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Ramo de Seguro:</label>
                        <select name="ramo_de_seguro" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text"/>
                            <option disabled selected>{{ $incapacidad->ramo_de_seguro }}</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Días Autorizados:</label>
                        <input readonly id="dias_autorizados" name="dias_autorizados" type="number" min="1" value="{{$incapacidad->dias_autorizados}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Días Acumulados:</label>
                        <input readonly id="dias_acumulados" name="dias_acumulados" type="number" value="{{$dias_acumulados}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" @if ($dias_acumulados >= 30) style="color: red;" @endif />
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre del Doctor:</label>
                        <input readonly type="text" value="{{$incapacidad->nombre_doctor}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Matrícula del Doctor:</label>
                        <input readonly name="matricula_doctor" type="text" value="{{$incapacidad->matricula_doctor}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Padecimiento:</label>
                        <select name="padecimiento" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text"/>
                            <option disabled selected> {{ $incapacidad->padecimientos->padecimiento_nombre }}</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Diagnóstico:</label>
                        <textarea readonly name="diagnostico" name="diagnostico" type="text" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" style="max-height: 150px; min-height: 70px;" required/>{{$incapacidad->diagnostico}}</textarea>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Observaciones:</label>
                        <textarea readonly name="observaciones" type="text" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/ style="max-height: 150px; min-height: 70px;">{{$incapacidad->observaciones}}</textarea>
                    </div>

                    <div class="grid grid-cols-1">
                        <label for="archivo" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Archivo
                            relacionado:</label>
                        <a class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        @if($archivo)
                            href="{{ asset($archivo->getFilePath()) }}"
                        @endif
                        target="_blank">{{ $archivo->nombre_archivo ?? 'Sin archivo relacionado'}}</a>
                    </div>
                </div>
                <div class='flex items-center justify-center  md:gap-8 gap-4 py-3 5 mt-3'>
                    <a href="{{ route('incapacidades.index') }}" style="text-decoration:none" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>
