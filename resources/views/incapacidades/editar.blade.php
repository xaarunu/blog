<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Incapacidad') }}
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

    @if($errors->any())
        <div class="d-flex justify-center mt-3">
            <div class="w-3/5 alert alert-danger rounded my-0" role="alert">
                <h5>Ocurrio un error</h5>
                <span>{{ implode('', $errors->all(':message')) }}</span>
            </div>
        </div>
    @endif

    <div class="py-12">
        <x-boton-regresar />
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <form action="{{ route('incapacidades.update', $incapacidad->id) }}" method="POST" enctype="multipart/form-data" class="formEnviar w-auto">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8 mt-3 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE:</label>
                        <input readonly oninput="bloquearUsuario();" name="rpe" id="rpe" value="{{$datosuser->rpe}}" type="text" maxlength="5" minlength="5"
                            class="py-2 px-3 bg-gray-300 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            required />
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
                        <input readonly onchange="bloquearUsuario();" minlength="5" required name="nombrefalse" id='solicitante' value="{{$nombre}}" type="text" class="py-2 px-3 bg-gray-300 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*No. Certificado:</label>
                        <input required maxlength="12" value="{{$incapacidad->certificado}}" minlength="8" name="certificado" id='certificado' type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Unidad Médica:</label>
                        <select name="unidad_medica" id="unidad_medica" required
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="" disabled selected>Selecciona una opción</option>
                            @foreach ($unidades as $unidad)
                                @if ($unidad->id == old('unidad_medica') || $datosuser && $datosuser->datosUnidad?->unidad == $unidad->id )
                                    <option id="{{ $unidad->id }}" value="{{ $unidad->id }}" selected>
                                        {{ $unidad->nombre }}</option>
                                @else
                                    <option id="{{ $unidad->id }}" value="{{ $unidad->id }}">
                                        {{ $unidad->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Consultorio:</label>
                        <input name="consultorio" id="consultorio"
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required value="{{ old('consultorio') ?? ($datosuser ? $datosuser->datosUnidad?->consultorio : '') }}" />
                    </div>

                    <div class="grid grid-cols-1">
                        <label for="turno" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Turno:</label>
                        <select name="turno" id="turno" required
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="matutino" {{ (old('turno') == 'matutino' || $datosuser && $datosuser->datosUnidad?->turno == 'matutino') ? 'selected' : '' }}>Matutino</option>
                            <option value="vespertino" {{ (old('turno') == 'vespertino' || $datosuser && $datosuser->datosUnidad?->turno == 'vespertino') ? 'selected' : '' }}>Vespertino</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Tipo de Incapacidad:</label>
                        <select name="tipo" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                            <option value="Inicial" {{ ($incapacidad->tipo == "Inicial") ? 'selected' : ''}}>Inicial</option>
                            <option value="Subsecuente" {{ ($incapacidad->tipo == "Subsecuente") ? 'selected' : ''}}>Subsecuente</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Fecha inicio:</label>
                        <input onchange="calcularDias();" id="fecha_inicio" type="date" value="{{$incapacidad->fecha_inicio}}" name="fecha_inicio" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Fecha fin:</label>
                        <input  onchange="calcularDias();" id="fecha_fin" type="date" value="{{$incapacidad->fecha_fin}}" name="fecha_fin" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Ramo de Seguro:</label>
                        <select name="ramo_de_seguro" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                            <option value="General" {{ ($incapacidad->ramo_de_seguro == "General") ? 'selected' : ''}}>General</option>
                            <option value="Riesgo de trabajo" {{ ($incapacidad->ramo_de_seguro == "Riesgo de trabajo") ? 'selected' : ''}}>Riesgo de trabajo</option>
                            <option value="Maternidad" {{ ($incapacidad->ramo_de_seguro == "Maternidad") ? 'selected' : ''}}>Maternidad</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Días Autorizados:</label>
                        <input onchange="bloqueoCampo();" readonly id="dias_autorizados" name="dias_autorizados" type="number" min="1" value="{{$incapacidad->dias_autorizados}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold"></label>
                        {{-- <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Días Acumulados:</label> --}}
                        <input readonly id="dias_acumulados" name="dias_acumulados" type="hidden" value="{{$dias_acumulados}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                        {{-- <input readonly id="dias_acumulados" name="dias_acumulados" type="number" value="{{$dias_acumulados}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/> --}}
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Nombre del Doctor:</label>
                        <input name="nombre_doctor" type="text" value="{{$incapacidad->nombre_doctor}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Matrícula del Doctor:</label>
                        <input name="matricula_doctor" type="text" value="{{$incapacidad->matricula_doctor}}" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Padecimiento:</label>
                        <select name="padecimiento" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($padecimientos as $padecimiento)
                                <option value="{{ $padecimiento->id }}"
                                    @if(old('padecimiento'))
                                        {{ $padecimiento->id == old('padecimiento') ? 'selected' : '' }}
                                    @else
                                        {{ $padecimiento->id == $incapacidad->padecimiento ? 'selected' : '' }}
                                    @endif >
                                    {{ $padecimiento->padecimiento_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Diagnóstico:</label>
                        <textarea id="diagnostico" name="diagnostico" type="text" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" style="max-height: 150px; min-height: 70px;" required/>{{$incapacidad->diagnostico}}</textarea>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Observaciones:</label>
                        <textarea name="observaciones" type="text" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/ style="max-height: 150px; min-height: 70px;">{{$incapacidad->observaciones}}</textarea>
                    </div>

                    <div class="grid grid-cols-1 position-relative">
                        <label for="archivo" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Archivo
                            relacionado:</label>
                        <input id="nuevoArchivo" name="archivo" onchange="validateFile(this);" type="file" accept=".pdf"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            @if($archivo and !$errors->has('archivo'))
                                hidden
                            @endif
                            />
                        <div id="fileError" class="position-absolute alert alert-danger mt-2 mb-7" style="top:100%; right: 0;" role="alert" hidden>
                            <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                            </svg>
                            <span class="ml-1">Por favor, suba un archivo PDF.</span>
                        </div>
                        @if(!$errors->has('archivo') and $archivo)
                            <div id="archivoOriginal" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent d-flex justify-between flex-col">
                                <a href="{{asset($archivo->getFilePath())}}" target="_blank">{{$archivo->nombre_archivo}}</a>
                                <button onclick="cambiaInput();" type="button" class="btn btn-secondary">Cambiar archivo</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class='flex items-center justify-center  md:gap-8 gap-4 py-3 5 mt-3'>
                    <!-- botón cancelar -->
                    <a href="{{ route('incapacidades.index') }}" style="text-decoration:none" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <!-- botón enviar -->
                    @if(!session('message'))
                        <button type="submit" class="w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Actualizar</button>
                    @endif
                </div>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form
  var loader = document.getElementById("preloader");    //Se guarda el loader en la variable.
  var forms = document.querySelectorAll('.formEnviar')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
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
                    Swal.fire('¡Enviado!', 'El formulario ha sido enviado exitosamente.','success');
                }
                else {
                    //Se oculta el loader para que no tape toda la pantalla por siempre.
                    loader.style.display = "none";
                }
            })
      }, false)
    })})();
</script>

<script>
    var dias_autorizados = "";
    function calcularDias() {
        var fecha_inicio = document.getElementById('fecha_inicio').value;
        var fecha_fin = document.getElementById('fecha_fin').value;

        if (fecha_inicio && fecha_fin && fecha_inicio <= fecha_fin) {
            var fecha_inicio_date = new Date(fecha_inicio);
            var fecha_fin_date = new Date(fecha_fin);

            var diferenciaMilisegundos = fecha_fin_date - fecha_inicio_date;

            var diasDiferencia = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24)) + 1;

            // Resta los fines de semana de la diferencia total
            var diasTotales = diasDiferencia;

            document.getElementById('dias_autorizados').value = parseInt(diasTotales);
            dias_autorizados = parseInt(diasTotales);
            cambioDias();
        }
        else {
            document.getElementById('dias_autorizados').value = "";
            dias_autorizados = "";
            cambioDias();
        }
    }
</script>

<script>
    function cambioDias() {
        var dias_acumulados = '<?php echo $dias_acumulados; ?>';

        var dias_autorizados = document.getElementById('dias_autorizados').value;

        if (dias_autorizados > 0) {
            document.getElementById('dias_acumulados').value = parseInt(dias_acumulados) + parseInt(dias_autorizados);
        }
        else {
            document.getElementById('dias_acumulados').value = parseInt(dias_acumulados);
        }

        $("#fecha_fin").attr("min", $('#fecha_inicio').val());
    }
</script>

<script>
    function bloquearUsuario() {
        alert("No esta permitido cambiar este campo!.");
        document.getElementById('rpe').setAttribute('readonly', true);
        document.getElementById('solicitante').setAttribute('readonly', true);

        document.getElementById('rpe').value = {!! json_encode($incapacidad->rpe) !!};
        document.getElementById('solicitante').value = {!! json_encode($nombre) !!}
    }
</script>

<script>
    function bloqueoCampo() {
        document.getElementById('dias_autorizados').value = dias_autorizados;
        alert("Asigne días estableciendo un periodo de fechas válido.");
    }
</script>

<script>
    const validFileExtensions = ["pdf", "doc", "docx"];

    function validateFile(input) {
        const uploadedFileType = input.value.split('.').pop();
        const validFile = validFileExtensions.includes(uploadedFileType);

        if(validFile) {
            $('#fileError').attr('hidden', true);
        } else {
            $('#fileError').removeAttr('hidden');
        }
    }

    function cambiaInput() {
        document.getElementById('archivoOriginal').classList.remove('d-flex');
        document.getElementById('archivoOriginal').setAttribute('hidden', true);

        document.getElementById('nuevoArchivo').removeAttribute('hidden');
        document.getElementById('nuevoArchivo').setAttribute('required', true);
    }
</script>
<style>
    .d-flex {
        align-items:center;
    }
    @media screen and (min-width: 500px) {
        .d-flex {
            flex-direction: row;
        }
    }
</style>
