<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Nota Médica') }}
        </h2>
    </x-slot>
    <style>
        /* CHECKBOX TOGGLE SWITCH */
        /* @apply rules for documentation, these do not work as inline style */
        .toggle-checkbox:checked {
            @apply: right-0 border-green-400;
            right: 0;
            border-color: #68D391;
        }

        .toggle-checkbox:checked+.toggle-label {
            @apply: bg-green-400;
            background-color: #68D391;
        }
    </style>
    <x-boton-regresar />
    <div class="alert" id="elementoOculto" style=" display: none;  background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
        <p style="color: #571515;">No se encontró un antecedente para el RPE especificado. Por favor, crea un antecedente.
            <a id="a1" style="all: revert" href="{{ route('personales.create',0) }}">Crear Antecedente</a>
        </p>

    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p
                class="flex items-center justify-center w-auto bg-green-400 hover:bg-white-500 rounded-lg shadow-xl font-medium text-black px-1 py-1">
                <i>IMC se genera automático (altura(metros) * altura(metros)) / peso<br>
                    Antes de 25 <b>NORMAL</b>. 25 a 29 <b>SOBRE PESO</b>. 30 a 34 <b>OBESIDAD TIPO 1</b>. 35 a 39
                    <b>OBESIDAD TIPO 2</b>. más de 40 <b>OBESIDAD MORBIDA</b></i>
            </p>
            <br>
            <p id="fechaParaMostrar" class="flex items-center justify-center w-auto bg-green-400 hover:bg-white-500 rounded-lg shadow-xl font-medium text-black px-1 py-1"
            @if(!$datosAnteriores) style="display:none; " @endif >
                <i> <b>Ultima nota médica echa en la fecha: </b> <span> {{ $datosAnteriores?->fecha }}</span> </i>
            </p>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('saluds.store') }}" method="POST" enctype="multipart/form-data" class="formEnviar"
                    id="exp">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE:</label>
                            @if (Auth::user()->hasRole('Doctora') || Auth::user()->hasRole('admin') )
                                <input  name="rpe" id="rpe" value="{{$datosuser ? $datosuser->rpe : old('rpe')}}" type="text" maxlength="5" minlength="5" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required
                                @if ($datosuser) readonly oninput="bloquearCampo(this);" @endif />
                            @else
                                <input readonly name="rpe" id="rpe" value="{{$datosuser ? $datosuser->rpe : ''}}" type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                            @endif
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                            <input readonly minlength="5" required name="nombrefalse" id='solicitante' value="{{$nombre ? $nombre : old('nombrefalse')}}" type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            @if ($datosuser) oninput="bloquearCampo(this);" @endif />
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                                nacimiento:</label>
                            <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" min="1900-01-01" max="{{ date('Y-m-d') }}"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{$antecedente ? $antecedente->fecha_nacimiento : old('fecha_nacimiento')}}" readonly/>
                            @error('fecha_nacimiento')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Sexo:</label>
                            <select name="sexo" id="sexo"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required >
                            <option value="Femenino" {{old('sexo') == 'Femenino' ? 'selected' : ''}}>Femenino</option>
                            <option value="Masculino" {{old('sexo') == 'Masculino' ? 'selected' : ''}}>Masculino</option>
                            </select>
                            @error('sexo')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha:</label>
                            <input id="fecha" name="fecha" id="fecha" type="date"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required readonly />
                            @error('fecha')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Hora:</label>
                            <input name="hora" id="hora" type="time"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            @error('hora')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Altura:
                                (m.)</label>
                            <input id="altura" name="altura" type="number" min="0.30" max="3"
                                step=".01"
                                value="{{ !empty($datosAnteriores->altura) ? $datosAnteriores->altura : (!empty($antecedente->altura) ? $antecedente->altura : old('altura')) }}"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required />
                            @error('altura')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Peso:
                                (kg.)</label>
                            <input id="peso" name="peso" type="number" min="2" max="635"
                                step=".01"
                                value="{{ !empty($datosAnteriores->peso) ? $datosAnteriores->peso : (!empty($antecedente->peso) ? $antecedente->peso : old('peso')) }}"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required />
                            @error('peso')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Indice de
                                Masa Corporal:</label>
                            <input id="imc" readonly name="imc" type="text"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required />
                            @error('imc')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Medida de
                                cintura: (cm.)</label>
                            <input id="cintura" name="cintura" type="number" min="1" max="200" step=".01"
                                value="{{ !empty($datosAnteriores->cintura) ? $datosAnteriores->cintura : (!empty($antecedente->cintura) ? $antecedente->cintura : old('cintura')) }}"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            @error('cintura')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Medida
                                de cadera: (cm.)</label>
                            <input id="cadera" name="cadera" type="number" min="1" max="200"
                                value="{{ !empty($datosAnteriores->cadera) ? $datosAnteriores->cadera : (!empty($antecedente->cadera) ? $antecedente->cadera : old('cadera')) }}"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            @error('cadera')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Presion
                                arterial: (Hg/mm)</label>
                            <div class="grid grid-cols-5">
                                <input id="presionSis" name="presionSis" type="number" min="1" max="500"
                                    class=" py-1 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required value="{{old('presionSis')}}"/>
                                <input  name="none" value="/" disabled
                                    style="text-align:center; font-size:20px"
                                    class="font-bold py-1 px-3 justify-items-center justify-center  border-transparent mt-1"
                                    type="text" />
                                <input id="presionDia" name="presionDia" type="number" min="1" max="500"
                                    class=" py-1 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required value="{{old('presionDia')}}" />
                            </div>
                            @error('presionSis')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('presionDia')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nivel de
                                temperatura: (°C)</label>
                            <input id="temperatura" name="temperatura" type="number" min="1" max="100" step=".1"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{old('temperatura')}}"/>
                            @error('temperatura')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nivel de
                                saturación: (%)</label>
                            <input id="saturacion" name="saturacion" type="number" min="1" max="100"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{old('saturacion')}}"/>
                            @error('saturacion')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nivel de
                                glucosa:</label>
                            <input id="glucosa" name="glucosa" type="number" min="1" max="500"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                value="{{!empty($datosAnteriores->glucosa) ? $datosAnteriores->glucosa : (!empty($antecedente->glucosa) ? $antecedente->glucosa : old('glucosa'))}}"
                                type="text" required />
                            @error('glucosa')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Frecuencia
                                cardiaca: (lat/min)</label>
                            <input id="cardiaca" name="cardiaca" type="number" min="1" max="300"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{old('cardiaca')}}" />
                            @error('cardiaca')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Frecuencia
                                respiratoria:</label>
                            <input id="respiratoria" name="respiratoria" type="number" min="1" max="100"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{old('respiratoria')}}"/>
                            @error('respiratoria')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Alergías:</label>
                            <div
                                class=" py-3 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent ">
                                <input type="checkbox" id="a4" name="Alimentos"
                                    {{ isset($datosAnteriores->alergias) ? (str_contains($datosAnteriores->alergias, 'Alimentos') ? 'checked' : '') : '' }}
                                    @if(old('Alimentos') == 'on') checked="checked" @endif/>
                                <label
                                    for="Alimentos" class="md:text-sm text-xs text-gray-800 text-light font-semibold">Alimentos</label>
                                <input type="checkbox" id="a2" name="Medicamentos"
                                    {{ isset($datosAnteriores->alergias) ? (str_contains($datosAnteriores->alergias, 'Medicamentos') ? 'checked' : '') : '' }}
                                    @if(old('Medicamentos') == 'on') checked="checked" @endif/>
                                <label
                                    for="Medicamentos"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Medicamentos</label>
                                <input type="checkbox" id="a3" name="Animales"
                                    {{ isset($datosAnteriores->alergias) ? (str_contains($datosAnteriores->alergias, 'Animales') ? 'checked' : '') : '' }}
                                    @if(old('Animales') == 'on') checked="checked" @endif/>
                                <label
                                    for="Animales"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Animales</label>
                                <input type="checkbox" id="a0" name="Ninguna"
                                    @if(old('Ninguna') == 'on') checked="checked" @endif/>
                                <label
                                    for="Ninguna"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Ninguna</label>
                            </div>
                        </div>
                        <input name="alergias" id="alergias" hidden value="Ninguna" required>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Descripción
                                de alergía:</label>
                            <textarea id="tipo" name="tipo" style="resize:none" maxlength="65535"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ !empty($datosAnteriores->tipo) ? $datosAnteriores->tipo : (!empty($antecedente->tipo) ? $antecedente->tipo : (old('tipo') ?? 'N/A')) }}</textarea>
                            @error('tipo')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Enfermedades
                                cronicas degenerativas:</label>
                            <div class="flex flex-col rounded border-2 border-green-600 py-1">
                                @foreach ($enfermedades as $enfermedad)
                                    <div class="ml-1">
                                        @if ($enfermedad['activado'])
                                            <input id="{{ $enfermedad['id'] }}" name="{{ $enfermedad['id'] }}"
                                                type="checkbox" checked>
                                        @else
                                            <input id="{{ $enfermedad['id'] }}" name="{{ $enfermedad['id'] }}"
                                                type="checkbox" @if(old($enfermedad['id']) == 'on') checked="checked" @endif>
                                        @endif

                                        <label for="{{ $enfermedad['id'] }}">{{ $enfermedad['nombre'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nota de
                                padecimiento actual:</label>
                            <textarea id="observaciones" name="observaciones" style="resize:none" maxlength="65535"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ !empty($datosAnteriores->observaciones) ? $datosAnteriores->observaciones : (!empty($antecedente->observaciones) ? $antecedente->observaciones : (old('observaciones') ?? 'N/A')) }}</textarea>
                            @error('observaciones')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Diagnostico:</label>
                            <textarea id="diagnostico" name="diagnostico" style="resize:none" maxlength="65535"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ !empty($datosAnteriores->diagnostico) ? $datosAnteriores->diagnostico : (!empty($antecedente->diagnostico) ? $antecedente->diagnostico : (old('diagnostico') ?? 'N/A' )) }}</textarea>
                            @error('diagnostico')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tratamiento:</label>
                            <textarea id="tratamiento" name="tratamiento" style="resize:none" maxlength="65535"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ !empty($datosAnteriores->tratamiento) ? $datosAnteriores->tratamiento : (!empty($antecedente->tratamiento) ? $antecedente->tratamiento : old('tratamiento')) }}</textarea>
                            @error('tratamiento')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.min.css') }}"
                            type="text/css" />
                        <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
                        <script>
                            Dropzone.autoDiscover = false;
                        </script>

                        <div class="dropzone py-2 px-3 rounded-lg border-green-500 !important" style="border-color: rgb(53, 167, 101)" id="archivo">
                        </div>
                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-5'>
                        <!-- botón cancelar -->
                        <a href="{{ route('saluds.showAllNotasMedicas') }}" style="text-decoration:none"
                            class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                        <!-- botón enviar -->
                        <button type="submit"
                            class="w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

<!-- Script para multiples tipos de alergias-->
<script>
    $(function() {
        $('#a0').on('change', function() {
            var btn1 = document.getElementById("a4");
            var btn2 = document.getElementById("a2");
            var btn3 = document.getElementById("a3");
            var tip = document.getElementById("tipo");
            if ($(this).prop('checked')) {
                $('#a4').prop('checked', false);
                $('#a2').prop('checked', false);
                $('#a3').prop('checked', false);
                $('#alergias').attr('value', "Ninguna");
            }
            if (!$(this).prop('checked')) {
                $('#a0').prop('checked', true);
                $('#alergias').attr('value', "Ninguna");
            }
        });

        $('#a4, #a2, #a3').on('change', function() {
            var noone = document.getElementById("a0");
            if ($(this).prop('checked')) {
                $('#a0').prop('checked', false);
                var alrg = "";
                if ($('#a4').prop('checked')) {
                    alrg = "Alimentos ";
                }
                if ($('#a2').prop('checked')) {
                    alrg = alrg + "Medicamentos ";
                }
                if ($('#a3').prop('checked')) {
                    alrg = alrg + "Animales ";
                }
                $('#alergias').attr('value', alrg);
            }
            if (!$('#a4').prop('checked') && !$('#a2').prop('checked') && !$('#a3').prop('checked')) {
                $('#a0').prop('checked', true);
                $('#alergias').attr('value', "Ninguna");
            }
        });
    });
</script>

<script>
    $(document).ready(function(e) {
        $('#imagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada1').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('#imagen2').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada2').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

    });
</script>

<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
        var forms = document.querySelectorAll('.formEnviar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirmar el envio?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Enviado!', 'El registro ha sido enviado exitosamente.',
                                'success');
                        } else {
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })
    })();
</script>

<script>
    //Obtener el día actual.
    $(document).ready(function() {
        var date = new Date();

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;
        $("#fecha").attr("value", today);
        $("#fechaA").attr("value", today);
        $("#fecha").attr("max", today);
        $("#fechaA").attr("max", today);
    });
</script>

<script>
    $(document).ready(function() {
        setInterval(() => {
            imcFunction()
            startTime()
        }, 1000);
    });
</script>
<script>
    function imcFunction() {
        var peso = document.getElementById("peso").value;
        var altura = document.getElementById("altura").value;

        var imc = peso / (altura * altura);

        document.getElementById("imc").value = imc.toFixed(1);
    };

    function imagenesComprobar() {
        var imagen = document.getElementById("imagen").value;
        var imagen2 = document.getElementById("imagen2").value;

        if (imagen == "" || imagen2 == "") {
            Swal.fire('¡Error!', 'Falta agregar fotos.', 'warning');
            return false;
        }
    };
</script>

<script>
    //Obtener la hora actual.
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();

        // Asegúrate de que ambos h y m tengan dos dígitos
        var hour = h.toString().padStart(2, '0') + ":" + m.toString().padStart(2, '0');

        $("#hora").val(hour);
    }


    dropzone = new Dropzone('#archivo', {

        autoProcessQueue: false,
        uploadMultiple: true,
        url: "{{ route('saluds.store') }}",
        dictDefaultMessage: "Arrastre archivos aquí o haga click para subir",


        init: function() {
            var myDropzone = this;
            const form = document.getElementById('exp');

            // First change the button to actually tell Dropzone to process the queue.
            form.querySelector("button[type=submit]").addEventListener("click", async function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                const data = new FormData(form);
                for (const archivo of myDropzone.getQueuedFiles()) {
                    data.append('archivo[]', archivo);
                }
                const res = await fetch("{{ route('saluds.store') }}", {
                    method: 'POST',
                    body: data,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                });
                if(res.redirected){
                    //console.log(res.redirected)
                    window.history.pushState({}, "", res.url);
                    document.open();
                document.write(await res.text());
                document.close();
                }

                // myDropzone.processQueue();
            });
        }
    });
</script>
<script>
    //busqueda por RPE
    var SITEURL = "{{ url('/') }}";
    document.getElementById('rpe').addEventListener("input", (e) => {
        if (e.srcElement.value.length >= 5) {
            elementoOculto.style.display = "none"; // Ocultar el mensaje
            fetch(`${SITEURL}/saluds/crearnota/buscar?rpe=${e.srcElement.value}`, { method: 'get' })
                .then(response => response.json())
                .then(data => {
                    if(data.tiene_antecedente){
                        const datosAnteriores = data.datosAnteriores || {};
                        const antecedente = data.antecedente || {};
                        document.getElementById("solicitante").value =data.datosuser.nombreCompleto;
                        document.getElementById("fecha_nacimiento").value =datosAnteriores.fecha_nacimiento|| antecedente.fecha_nacimiento || "";
                        document.getElementById("sexo").value =datosAnteriores.sexo|| antecedente.sexo || "";
                        // document.getElementById("fecha").value =datosAnteriores.fecha|| "";
                        document.getElementById("hora").value =datosAnteriores.hora|| "";
                        document.getElementById("altura").value =datosAnteriores.altura|| antecedente.altura || "";
                        document.getElementById("peso").value =datosAnteriores.peso|| antecedente.peso || "";
                        document.getElementById("imc").value =datosAnteriores.imc|| "";
                        document.getElementById("cintura").value =datosAnteriores.cintura|| antecedente.cintura || "";
                        document.getElementById("cadera").value =datosAnteriores.cadera|| antecedente.cadera || "";
                        document.getElementById("tipo").value =datosAnteriores.tipo|| antecedente.tipo || "";
                        document.getElementById("observaciones").value =datosAnteriores.observaciones|| antecedente.observaciones || "";
                        document.getElementById("diagnostico").value =datosAnteriores.diagnostico|| antecedente.diagnostico || "";
                        document.getElementById("tratamiento").value =datosAnteriores.tratamiento|| antecedente.tratamiento || "";
                        const enfermedadesArreglos = data.enfermedadesArreglos || {};
                        // Obtén las enfermedades del objeto data
                        const enfermedades = Object.values(enfermedadesArreglos);
                        enfermedades.forEach(enfermedad => {
                            const checkbox = document.getElementById(`${enfermedad.id}`);
                            checkbox.checked = enfermedadesArreglos[enfermedad.nombre].activado;
                        });
                        // Obtén las alergias del objeto data
                        const alergias = datosAnteriores.alergias || "";
                        // Activar las casillas del checklist según las alergias
                        document.getElementById("a4").checked = alergias.includes("Alimentos");
                        document.getElementById("a2").checked = alergias.includes("Medicamentos");
                        document.getElementById("a3").checked = alergias.includes("Animales");
                        document.getElementById("a0").checked = alergias === "Ninguna";

                        if(datosAnteriores.fecha) {
                            document.getElementById("fechaParaMostrar").style  = 'display: flex;';
                            document.querySelector('#fechaParaMostrar span').innerHTML = datosAnteriores.fecha;
                        }

                    }else{
                        var ruta = "{{route('personales.create', 'id')}}";
                        ruta = ruta.replace('id', e.srcElement.value);
                        elementoOculto.style.display = "block"; // Mostrar el mensaje
                        document.getElementById("a1").href = ruta;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // RPE no encontrado, establece los valores en nulo
                    document.getElementById("solicitante").value = "";
                    document.getElementById("rpe").value = "";
                });
        } else {
            document.getElementById("solicitante").value = "";
            document.getElementById("fechaParaMostrar").style  = 'display: none;';
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtén una referencia a los campos de entrada
        var alturaInput = document.getElementById('altura');
        var pesoInput = document.getElementById('peso');
        var presionSisInput = document.getElementById('presionSis');
        var presionDiaInput = document.getElementById('presionDia');
        var cinturaInput = document.getElementById('cintura');
        var caderaInput = document.getElementById('cadera');
        var temperaturaInput = document.getElementById('temperatura');
        var saturacionInput = document.getElementById('saturacion');
        var glucosaInput = document.getElementById('glucosa');
        var cardiacaInput = document.getElementById('cardiaca');
        var respiratoriaInput = document.getElementById('respiratoria');
        // Otros campos de entrada...

        // Agrega eventos de validación
        alturaInput.addEventListener('input', function () {
            validarValorNoNegativo(alturaInput);
        });

        pesoInput.addEventListener('input', function () {
            validarValorNoNegativo(pesoInput);
        });

        presionSisInput.addEventListener('input', function () {
            validarValorNoNegativo(presionSisInput);
        });

        presionDiaInput.addEventListener('input', function () {
            validarValorNoNegativo(presionDiaInput);
        });
        cinturaInput.addEventListener('input', function () {
            validarValorNoNegativo(cinturaInput);
        });
        caderaInput.addEventListener('input', function () {
            validarValorNoNegativo(caderaInput);
        });
        temperaturaInput.addEventListener('input', function () {
            validarValorNoNegativo(temperaturaInput);
        });
        saturacionInput.addEventListener('input', function () {
            validarValorNoNegativo(saturacionInput);
        });
        glucosaInput	.addEventListener('input', function () {
            validarValorNoNegativo(glucosaInput	);
        });
        cardiacaInput.addEventListener('input', function () {
            validarValorNoNegativo(cardiacaInput);
        });
        respiratoriaInput.addEventListener('input', function () {
            validarValorNoNegativo(respiratoriaInput);
        });
         // Función para mostrar alerta personalizada
         function mostrarAlerta(mensaje, estilo) {
            var alertaDiv = document.createElement('div');
            alertaDiv.innerHTML = mensaje;
            alertaDiv.className = 'mi-alerta ' + estilo;

            // Agregar la alerta al cuerpo del documento
            document.body.appendChild(alertaDiv);

            // Después de un tiempo, elimina la alerta
            setTimeout(function () {
                alertaDiv.remove();
            }, 3000); // Muestra la alerta durante 3 segundos (puedes ajustar el tiempo según tus necesidades)
        }
        // Función para validar valores no negativos
        function validarValorNoNegativo(input) {
            var valor = parseFloat(input.value);
            if (isNaN(valor) || valor < 0) {
                mostrarAlerta('El valor debe ser un número no negativo.', 'error');
                input.value = ''; // Limpiar el valor si es negativo o no es un número
            }
        }

    });
</script>
<script>
    const usuarioEspecificado = @json($datos);

    function bloquearCampo(input) {
        alert("No esta permitido cambiar este campo!.");
        input.setAttribute('readonly', true);

        if(input.id === 'rpe') {
            input.value = usuarioEspecificado.rpe;
        } else {
            input.value = [usuarioEspecificado.nombre, usuarioEspecificado.paterno, usuarioEspecificado.materno].join(' ');
        }
    }
</script>
<style>
    /* Estilos de la alerta personalizada */
    .mi-alerta {
        width: 400px; /* Ancho máximo de la alerta */
        height: 50px; /* Alto máximo de la alerta */
        color: #571515;
        background-color: #edd4d4;
        border: 1px solid #e6c3c3;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 0.5rem 1rem;
        margin-bottom: 1rem;
        border-radius: 10px;
        z-index: 9999;
        font-size: 16px;
        justify-content: center;
        align-items: center;
    }

    /* Estilos de la alerta personalizada de error */
    .error {
        background-color: #edd4d4; /* Puedes ajustar el color según tu diseño */
        color: #571515;
        border: 1px solid #e6c3c3;
    }
</style>
