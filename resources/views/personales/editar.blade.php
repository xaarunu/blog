<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Antecedentes Personales') }}
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
        .toggle-checkbox:checked + .toggle-label {
          @apply: bg-green-400;
          background-color: #68D391;
        }
    </style>

    <x-boton-regresar />

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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <form action="{{ route('personales.update', $antecedentes_personales->id) }}" method="POST" enctype="multipart/form-data" class="formEnviar">
            @method('PATCH')
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7 py-4">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE:</label>
                        <input name="rpe" value="{{$antecedentes_personales->rpe}}" class=" @error('rpe') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" value="{{old('rpe')}}" required readonly/>
                        @error('rpe')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                        <input readonly value="{{ $nombre }}" type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
                    </div>
                    <div class="grid md:col-span-2 grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">DIVISION:</label>
                            <input value="{{$usuario->getDivision->division_nombre}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" readonly/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">AREA:</label>
                            <input value="{{$usuario->getArea->area_nombre}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" readonly/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO DE TRABAJO:</label>
                            <input value="{{$usuario->getSubarea->subarea_nombre}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" readonly/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">NSS:</label>
                        <input name="nss" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required
                        value="{{old('nss') ?? $antecedentes_personales->nss}}"/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">UNIDAD MEDICA:</label>
                        <select name="unidad_medica" id="unidad_medica" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @foreach ($unidades as $unidad)
                                @if($unidad->id == old('unidad_medica'))
                                <option value="{{$unidad->id}}" selected>{{$unidad->nombre}}</option>
                                @else
                                    <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Consultorio:</label>
                        <input name="consultorio" id="consultorio" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required
                        value="{{old('consultorio') ?? $unidadMedica->consultorio}}"/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label for="turno" class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Turno:</label>
                        <select name="turno" id="turno" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="matutino" {{ (old('turno') == "matutino" ? "selected":"") }}>Matutino</option>
                            <option value="vespertino" {{ (old('turno') == "vespertino" ? "selected":"") }}>Vespertino</option>
                        </select>
                    </div>
                </div>

                <!--Antecedentes Personales -->
                <h2 class="font-semibold text-xl text-gray-800 leading-tight px-8 py-4"><br>Antecedentes Personales.</h2>

                <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                            nacimiento:</label>
                        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" min="1900-01-01" max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required value="{{old('fecha_nacimiento') ?? $antecedentes_personales->fecha_nacimiento}}"/>
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
                        <option value="Femenino" {{ (old('sexo') == "Femenino" ? "selected":"") }}>Femenino</option>
                        <option value="Masculino" {{ (old('sexo') == "Masculino" ? "selected":"") }}>Masculino</option>
                        </select>
                        @error('sexo')
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
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required value="{{ old('altura') ?? $antecedentes_personales->altura }}"/>
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
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required value="{{ old('peso') ?? $antecedentes_personales->peso }}"/>
                        @error('peso')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Indice de
                            Masa Corporal:</label>
                        <input id="imc" name="imc" type="text" readonly
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required/>
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
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required value="{{ old('cintura') ?? $antecedentes_personales->cintura }}"/>
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
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required value="{{ old('cadera') ?? $antecedentes_personales->cadera }}"/>
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
                                type="text" required value="{{ old('presionSis') ?? $antecedentes_personales->presionSis}}"/>
                            <input  name="none" value="/" disabled
                                style="text-align:center; font-size:20px"
                                class="font-bold py-1 px-3 justify-items-center justify-center  border-transparent mt-1"
                                type="text" />
                            <input id="presionDia" name="presionDia" type="number" min="1" max="500"
                                class=" py-1 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required value="{{ old('presionDia') ?? $antecedentes_personales->presionDia }}"/>
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
                            glucosa:</label>
                        <input id="glucosa" name="glucosa" type="number" min="1" max="500"
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required value="{{ old('glucosa') ?? $antecedentes_personales->glucosa }}"/>
                        @error('glucosa')
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
                            <input type="checkbox" id="a1" name="Alimentos" @if(old('Alimentos') == 'on') checked="checked" @endif>
                            <label for="Alimentos"
                                class="md:text-sm text-xs text-gray-800 text-light font-semibold">Alimentos</label>
                            <input type="checkbox" id="a2" name="Medicamentos" @if(old('Medicamentos') == 'on') checked="checked" @endif>
                            <label
                                for="Medicamentos"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Medicamentos</label>
                            <input type="checkbox" id="a3" name="Animales" @if(old('Animales') == 'on') checked="checked" @endif>
                            <label
                                for="Animales"class="md:text-sm text-xs text-gray-800 text-light font-semibold">Animales</label>
                            <input type="checkbox" id="a0" name="Ninguna" @if(old('Ninguna') == 'on') checked="checked" @endif>
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
                            type="text" required>{{ old('tipo') ?? $antecedentes_personales->tipo}}</textarea>
                        @error('tipo')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div><div class="grid grid-cols-1">
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
                            type="text" required>{{ old('observaciones') ?? $antecedentes_personales->observaciones}}</textarea>
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
                            type="text" required>{{ old('diagnostico') ?? $antecedentes_personales->diagnostico}}</textarea>
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
                            type="text" required>{{ old('tratamiento') ?? $antecedentes_personales->tratamiento}}</textarea>
                        @error('tratamiento')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Total de Vacunas Covid:</label>
                        <input name="vacuna" type="number" value="{{old('vacuna') ?? $antecedentes_personales->vacuna}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de la ultima vacuna:</label>
                        <input name="fecha_vacuna" type="date" min="1900-01-01" max="{{date('Y-m-d');}}" value="{{old('fecha_vacuna') ?? $antecedentes_personales->fecha_vacuna}}" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Inmunizaciones:</label>
                        <select name="inmunizaciones" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required>
                            <option value="">--Selecciona Inmunizacion--</option>
                            <option value="0" {{ $antecedentes_personales->inmunizaciones === 0 ? 'selected': '' }}>No</option>
                            <option value="1" {{ $antecedentes_personales->inmunizaciones === 1 ? 'selected': '' }}>Si</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cirugías:</label>
                        <textarea name="cirugia" rows="2" maxlength="191" style="resize:none" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent " type="text" required>{{old('cirugia') ?? $antecedentes_personales->cirugia}}</textarea>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Herencia:</label>
                        <textarea name="herencia" rows="2" maxlength="191" style="resize:none" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent " type="text" required>{{old('herencia') ?? $antecedentes_personales->herencia}}</textarea>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tabaquismo:</label>
                        <select name="tabaquismo" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required>
                            <option value="Si" {{old('tabaquismo') == 'Si' ? 'selected' : ''}}>Si</option>
                            <option value="No" {{old('tabaquismo') == 'No' ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Alcoholismo:</label>
                        <select name="alcholismo" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                            <option value="Si" {{old('alcholismo') == 'Si' ? 'selected' : ''}}>Si</option>
                            <option value="No" {{old('alcholismo') == 'No' ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Toxicomanias</label>
                        <select name="toxicomanias" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                            <option value="Si" {{old('toxicomanias') == 'Si' ? 'selected' : ''}}>Si</option>
                            <option value="No" {{old('toxicomanias') == 'No' ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                </div>

                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-5'>
                    <!-- botón cancelar -->
                    <a href="{{ route('personales.indice', $antecedentes_personales->rpe) }}" class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                    <!-- botón enviar -->
                    <form action="{{ route('personales.index') }}" method="POST" class="formEnviar bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">

                        <button type="submit" style="background-color: rgb(21 128 61);" class="bg--500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Guardar</button>
                    </form>
                </div>

            </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form
  var forms = document.querySelectorAll('.formEnviar')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
          event.preventDefault()
          event.stopPropagation()
          Swal.fire({
                title: '¿Confirmar el guardado?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire('Guardado!', 'El registro ha sido guardado exitosamente.','success');
                }
                //Se oculta el loader para que no tape toda la pantalla por siempre.
                else{
                    loader.style.display = "none";
                }
            })
      }, false)
    })})()

    // Obtener información ingresada previamente en los selects (si el primer select no tiene valor, los otros tampoco deberían)
    const informacionCargada = @json(old('unidad_medica'))

    // Seleccionar opciones iniciales en caso de ser la primera vez que se accede
    if(!informacionCargada) {
        // Obtener la información original del antecedente registrado
        const {sexo, tabaquismo, alcholismo, toxicomanias} = @json($antecedentes_personales);
        const {unidad, turno} = @json($unidadMedica);

        document.querySelector('[name="unidad_medica"]').value=unidad;
        document.querySelector('[name="turno"]').value=turno;

        document.querySelector('[name="sexo"]').value=sexo;

        document.querySelector('[name="tabaquismo"]').value=tabaquismo;
        document.querySelector('[name="alcholismo"]').value=alcholismo;
        document.querySelector('[name="toxicomanias"]').value=toxicomanias;
    }
</script>
<script>
    $(document).ready(function() {
        setInterval(() => {
            imcFunction()
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
</script>
