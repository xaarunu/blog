<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Antecedente') }}
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

    <div class="alert flex items-center gap-2" id="elementoOculto"
        style=" display: none; color: #571515; background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
        <p>El usuario con RPE especificado. Ya cuenta con un antecedente.</p>
        <a id="verExpediente" style="text-decoration: none" href="{{ route('personales.edit', 'sustituir') }}"
            class="rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4">Ver
        </a>
    </div>

    @if ($errors->any())
        <div class="mt-4 p-5 text-center bg-red-500 w-3/5 mx-auto rounded shadow-md text-white">
            <h5 class="text-xl">Ocurrio un error, verifica la información ingresada</h5>
            <ol>
                @foreach ($errors->all() as $error)
                    <li class="text-base">{{ $error }}</li>
                @endforeach
            </ol>
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p
                class="flex items-center justify-center w-auto bg-green-400 hover:bg-white-500 rounded-lg shadow-xl font-medium text-black px-1 py-1">
                <i>IMC se genera automático (altura(metros) * altura(metros)) / peso<br>
                    Antes de 25 <b>NORMAL</b>. 25 a 29 <b>SOBRE PESO</b>. 30 a 34 <b>OBESIDAD TIPO 1</b>. 35 a 39
                    <b>OBESIDAD TIPO 2</b>. más de 40 <b>OBESIDAD MORBIDA</b></i>
            </p>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('personales.store', $rpe) }}" method="POST" enctype="multipart/form-data"
                    class="formEnviar">

                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7 py-4">

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE:</label>
                            @if (Auth::user()->hasRole('Doctora') || Auth::user()->hasRole('admin'))
                                <input name="rpe" id="rpe" value="{{ $datos ? $datos->rpe : old('rpe') }}"
                                    type="text" maxlength="5" minlength="5"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    required
                                    @if ($datos) readonly oninput="bloquearCampo(this);" @endif />
                            @else
                                <input readonly name="rpe" id="rpe" value="{{ $datos ? $datos->rpe : '' }}"
                                    type="text"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    required />
                            @endif
                        </div>

                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                            <input readonly minlength="5" required name="nombrefalse" id='solicitante'
                                value="{{ $nombre ? $nombre : old('nombrefalse') }}" type="text"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                @if ($datos) oninput="bloquearCampo(this);" @endif />
                        </div>

                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">AREA:</label>
                            <input type="text" id="_areas_nombre" name="areas_nombre"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                value="{{ $areaUser ? $areaUser->area_nombre : old('areas_nombre') }}" readonly />
                            <input type="hidden" id="_areas" name="area"
                                value="{{ $areaUser ? $areaUser->area_clave : old('area') }}" readonly />

                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO DE
                                TRABAJO:</label>
                            <input type="text" id="_subareas_nombre" name="subareas_nombre"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                value="{{ $subareaUser ? $subareaUser->subarea_nombre : old('subareas_nombre') }}"
                                readonly />
                            <input type="hidden" name="subarea" id="_subareas"
                                value="{{ $subareaUser ? $subareaUser->subarea_clave : old('subarea') }}" readonly />
                        </div>

                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">NSS:</label>
                            <input name="nss"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{ old('nss') }}" />
                        </div>

                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">UNIDAD
                                MEDICA:</label>
                            <select name="unidad_medica" id="unidad_medica"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($unidades as $unidad)
                                    @if ($unidad->id == old('unidad_medica'))
                                        <option id="{{ $unidad->id }}" value="{{ $unidad->id }}" selected>
                                            {{ $unidad->nombre }}</option>
                                    @else
                                        <option id="{{ $unidad->id }}" value="{{ $unidad->id }}">
                                            {{ $unidad->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Consultorio:</label>
                            <input name="consultorio" id="consultorio"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{ old('consultorio') }}" />
                        </div>

                        <div class="grid grid-cols-1 ocultarInputs">
                            <label for="turno"
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Turno:</label>
                            <select name="turno" id="turno"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="matutino" {{ old('turno') == 'matutino' ? 'selected' : '' }}>Matutino
                                </option>
                                <option value="vespertino" {{ old('turno') == 'vespertino' ? 'selected' : '' }}>
                                    Vespertino</option>
                            </select>
                        </div>

                    </div>

                    <!--Antecedentes Personales -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-8 py-4"><br>Antecedentes Personales.
                    </h2>

                    <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                                nacimiento:</label>
                            <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" min="1900-01-01"
                                max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{ old('fecha_nacimiento') }}" />
                            @error('fecha_nacimiento')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Sexo:</label>
                            <select name="sexo" id="sexo"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>
                                <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino
                                </option>
                                <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino
                                </option>
                            </select>
                            @error('sexo')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Altura:
                                (m.)</label>
                            <input id="altura" name="altura" type="number" min="0.30" max="3"
                                step=".01"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{ old('altura') }}" />
                            @error('altura')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Peso:
                                (kg.)</label>
                            <input id="peso" name="peso" type="number" min="2" max="635"
                                step=".01"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{ old('peso') }}" />
                            @error('peso')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Indice
                                de
                                Masa Corporal:</label>
                            <input id="imc" name="imc" type="text" readonly
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{ old('imc') }}" />
                            @error('imc')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Medida
                                de
                                cintura: (cm.)</label>
                            <input id="cintura" name="cintura" type="number" min="1" max="200"
                                step=".01"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{ old('cintura') }}" />
                            @error('cintura')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Medida
                                de cadera: (cm.)</label>
                            <input id="cadera" name="cadera" type="number" min="1" max="200"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{ old('cadera') }}" />
                            @error('cadera')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Presion
                                arterial: (Hg/mm)</label>
                            <div class="grid grid-cols-5">
                                <input id="presionSis" name="presionSis" type="number" min="1"
                                    max="500"
                                    class=" py-1 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required value="{{ old('presionSis') }}" />
                                <input name="none" value="/" disabled
                                    style="text-align:center; font-size:20px"
                                    class="font-bold py-1 px-3 justify-items-center justify-center  border-transparent mt-1"
                                    type="text" />
                                <input id="presionDia" name="presionDia" type="number" min="1"
                                    max="500"
                                    class=" py-1 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required value="{{ old('presionDia') }}" />
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
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nivel de
                                glucosa:</label>
                            <input id="glucosa" name="glucosa" type="number" min="1" max="500"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{ old('glucosa') }}" />
                            @error('glucosa')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Alergías:</label>
                            <div
                                class=" py-3 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent ">
                                <input type="checkbox" id="a1" name="Alimentos"
                                    @if (old('Alimentos') == 'on') checked="checked" @endif>
                                <label for="Alimentos"
                                    class="md:text-sm text-xs text-gray-800 text-light font-semibold">Alimentos</label>
                                <input type="checkbox" id="a2" name="Medicamentos"
                                    @if (old('Medicamentos') == 'on') checked="checked" @endif>
                                <label
                                    for="Medicamentos"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Medicamentos</label>
                                <input type="checkbox" id="a3" name="Animales"
                                    @if (old('Animales') == 'on') checked="checked" @endif>
                                <label
                                    for="Animales"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Animales</label>
                                <input type="checkbox" id="a0" name="Ninguna"
                                    @if (old('Ninguna') == 'on') checked="checked" @endif>
                                <label
                                    for="Ninguna"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Ninguna</label>
                            </div>
                        </div>
                        <input name="alergias" id="alergias" hidden value="Ninguna" required>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Descripción
                                de alergía:</label>
                            <textarea id="tipo" name="tipo" style="resize:none" maxlength="65535"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ old('tipo') ?? 'N/A' }}</textarea>
                            @error('tipo')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
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
                                                type="checkbox">
                                        @endif

                                        <label for="{{ $enfermedad['id'] }}">{{ $enfermedad['nombre'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nota de
                                padecimiento actual:</label>
                            <textarea id="observaciones" name="observaciones" style="resize:none" maxlength="65535"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ old('observaciones') ?? 'N/A' }}</textarea>
                            @error('observaciones')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Diagnostico:</label>
                            <textarea id="diagnostico" name="diagnostico" style="resize:none" maxlength="65535"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ old('diagnostico') ?? 'N/A' }}</textarea>
                            @error('diagnostico')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tratamiento:</label>
                            <textarea id="tratamiento" name="tratamiento" style="resize:none" maxlength="65535"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ old('tratamiento') ?? 'N/A' }}</textarea>
                            @error('tratamiento')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Total de
                                Vacunas Covid:</label>
                            <input name="vacuna" type="number" min="0" max="99"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{ old('vacuna') }}" />
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                                la ultima vacuna:</label>
                            <input name="fecha_vacuna" type="date" min="1900-01-01" max="{{ date('Y-m-d') }}"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required value="{{ old('fecha_vacuna') }}" />
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Inmunizaciones:</label>
                            <select name="inmunizaciones"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                required>
                                <option value="">--Selecciona Inmunizacion--</option>
                                <option value="0" {{ old('inmunizaciones') === 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('inmunizaciones') === 1 ? 'selected' : '' }}>Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cirugías:</label>
                            <textarea name="cirugia" rows="2" style="resize:none" maxlength="191"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent "
                                type="text" required>{{ old('cirugia') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Enfermedades
                                hereditarias:</label>
                            <textarea name="herencia" rows="2" style="resize:none" maxlength="191"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required>{{ old('herencia') }}</textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tabaquismo:</label>
                            <select name="tabaquismo"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            <option value="No" {{ old('tabaquismo') == 'No' ? 'selected' : '' }}>No</option>
                            <option value="Si" {{ old('tabaquismo') == 'Si' ? 'selected' : '' }}>Si</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Alcoholismo:</label>
                            <select name="alcholismo"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            <option value="No" {{ old('alcholismo') == 'No' ? 'selected' : '' }}>No</option>
                            <option value="Si" {{ old('alcholismo') == 'Si' ? 'selected' : '' }}>Si</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 ocultarInputs">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Toxicomanias</label>
                            <select name="toxicomanias"
                                class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            <option value="No" {{ old('toxicomanias') == 'No' ? 'selected' : '' }}>No</option>
                            <option value="Si" {{ old('toxicomanias') == 'Si' ? 'selected' : '' }}>Si</option>
                            </select>
                        </div>
                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-5 ocultarInputs'>
                        <!-- botón cancelar -->
                        <a href="{{ route('personales.indice', $rpe) }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <!-- botón enviar -->
                        <form action="{{ route('personales.index') }}" method="POST"
                            class="formEnviar w-auto bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
                            <button id="btnEnviar" type="submit" style="background-color: rgb(21 128 61);"
                                class="w-auto bg--500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                        </form>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

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
    })()
</script>

<script>
    //busqueda por RPE
    var SITEURL = "{{ url('/') }}";
    const usuarioEspecificado = @json($datos);

    // Si no se especifica el usuario, añadir listener al rpe para encontrar al usuario deseado
    if (!usuarioEspecificado) {
        document.getElementById('rpe').addEventListener("input", (e) => {

            const ocultarInputs = document.querySelectorAll('.ocultarInputs');
            const verExpediente = document.querySelector('#verExpediente');



            ocultarInputs.forEach(inputs => {
                inputs.style.display = "grid";
            });

            ocultarInputs[ocultarInputs.length - 1].style.display = "flex";

            if (e.srcElement.value.length >= 5) {
                elementoOculto.style.display = "none"; // Ocultar el mensaje
                fetch(`${SITEURL}/personales/crearregistro/buscar?rpe=${e.srcElement.value}`, {
                        method: 'get'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.tieneAntecedente) {
                            ocultarInputs.forEach(inputs => {
                                inputs.style.display = "none";
                            });
                            elementoOculto.style.display = "flex"; // Mostrar el mensaje
                            const enlaceVerExpediente = verExpediente.href.replace("sustituir", e.srcElement
                                .value);
                            verExpediente.href = enlaceVerExpediente;
                        } else {
                            document.getElementById("solicitante").value = data.datouser.nombreCompleto;
                            document.getElementById("_areas").value = data.areas.area_clave;
                            document.getElementById("_areas_nombre").value = data.areas.area_nombre;
                            document.getElementById("_subareas").value = data.subareas.subarea_clave;
                            document.getElementById("_subareas_nombre").value = data.subareas
                                .subarea_nombre;
                            // document.getElementById("btnEnviar").removeAttribute("disabled");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // RPE no encontrado, establece los valores en nulo
                        document.getElementById("solicitante").value = "";
                        document.getElementById("rpe").value = "";
                    });
            } else if (e.srcElement.value.length <= 0) {
                // document.getElementById("btnEnviar").setAttribute("disabled", "");
            } else {
                document.getElementById("solicitante").value = "";
            }
        });
    } else {
        // document.getElementById("btnEnviar").removeAttribute("disabled");
    }
</script>
<script>
    $(document).ready(function() {
        setInterval(() => {
            imcFunction()
            // startTime() (No se encuentra la función)
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
    document.addEventListener('DOMContentLoaded', function() {
        // Obtén una referencia a los campos de entrada
        var alturaInput = document.getElementById('altura');
        var pesoInput = document.getElementById('peso');
        var presionSisInput = document.getElementById('presionSis');
        var presionDiaInput = document.getElementById('presionDia');
        var cinturaInput = document.getElementById('cintura');
        var caderaInput = document.getElementById('cadera');
        var glucosaInput = document.getElementById('glucosa');
        // Otros campos de entrada...

        // Agrega eventos de validación
        alturaInput.addEventListener('input', function() {
            validarValorNoNegativo(alturaInput);
        });

        pesoInput.addEventListener('input', function() {
            validarValorNoNegativo(pesoInput);
        });

        presionSisInput.addEventListener('input', function() {
            validarValorNoNegativo(presionSisInput);
        });

        presionDiaInput.addEventListener('input', function() {
            validarValorNoNegativo(presionDiaInput);
        });
        cinturaInput.addEventListener('input', function() {
            validarValorNoNegativo(cinturaInput);
        });
        caderaInput.addEventListener('input', function() {
            validarValorNoNegativo(caderaInput);
        });
        glucosaInput.addEventListener('input', function() {
            validarValorNoNegativo(glucosaInput);
        });
        // Función para mostrar alerta personalizada
        function mostrarAlerta(mensaje, estilo) {
            var alertaDiv = document.createElement('div');
            alertaDiv.innerHTML = mensaje;
            alertaDiv.className = 'mi-alerta ' + estilo;

            // Agregar la alerta al cuerpo del documento
            document.body.appendChild(alertaDiv);

            // Después de un tiempo, elimina la alerta
            setTimeout(function() {
                alertaDiv.remove();
            }, 3000); // Muestra la alerta durante 3 segundos (puedes ajustar el tiempo según tus necesidades)
        }
        // Función para validar valores no negativos
        function validarValorNoNegativo(input) {
            var valor = parseFloat(input.value);
            if (isNaN(valor) || valor < 0) {
                // alert('El valor debe ser un número no negativo.');
                mostrarAlerta('El valor debe ser un número no negativo.', 'error');
                input.value = ''; // Limpiar el valor si es negativo o no es un número
            }
        }

    });
</script>
<script>
    function bloquearCampo(input) {
        alert("No esta permitido cambiar este campo!.");
        input.setAttribute('readonly', true);

        if (input.id === 'rpe') {
            input.value = usuarioEspecificado.rpe;
        } else {
            input.value = [usuarioEspecificado.nombre, usuarioEspecificado.paterno, usuarioEspecificado.materno].join(
                ' ');
        }
    }
</script>
<style>
    /* Estilos de la alerta personalizada */
    .mi-alerta {
        width: 400px;
        /* Ancho máximo de la alerta */
        height: 50px;
        /* Alto máximo de la alerta */
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
        background-color: #edd4d4;
        /* Puedes ajustar el color según tu diseño */
        color: #571515;
        border: 1px solid #e6c3c3;
    }
</style>
