
<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Incapacidad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <x-boton-regresar />
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <form action="{{ route('incapacidades.store') }}" method="POST" enctype="multipart/form-data" class="formEnviar w-auto">
                @csrf
                @if ($errors->any())
                    <div class="error-message alert alert-danger bg-red-400 text-white p-4 rounded-lg mb-5">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>Inténtalo de nuevo. {{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*RPE:</label>
                        <input name="rpe" id="rpe" maxlength="5" type="text" required
                        @if($datosuser) value="{{ $datosuser->rpe }}" readonly class="bg-gray-200 mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" @endif
                        class="mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                        <input readonly minlength="5" required name="nombrefalse" id='solicitante' value="{{$nombre}}" type="text" class="py-2 px-3 bg-gray-200 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*No. Certificado:</label>
                        <input required maxlength="12" minlength="8" name="certificado" id='certificado' type="text" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Unidad Médica:</label>
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
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Consultorio:</label>
                        <input name="consultorio" id="consultorio"
                            class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            type="text" required value="{{ old('consultorio') ?? ($datosuser ? $datosuser->datosUnidad?->consultorio : '') }}" />
                    </div>

                    <div class="grid grid-cols-1">
                        <label for="turno" class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Turno:</label>
                        <select name="turno" id="turno" required
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="matutino" {{ (old('turno') == 'matutino' || $datosuser && $datosuser->datosUnidad?->turno == 'matutino') ? 'selected' : '' }}>Matutino</option>
                            <option value="vespertino" {{ (old('turno') == 'vespertino' || $datosuser && $datosuser->datosUnidad?->turno == 'vespertino') ? 'selected' : '' }}>Vespertino</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Tipo de Incapacidad:</label>
                        <select name="tipo" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                            <option value="">Seleccione una opción</option>
                            <option value="Inicial">Inicial</option>
                            <option value="Subsecuente">Subsecuente</option>
                            <!-- <option value="Prolongada">Prolongada</option> -->
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Fecha inicio:</label>
                        <input onchange="calcularDias();" id="fecha_inicio" name="fecha_inicio" type="date" {{--min="{{date('Y-m-d');}}"--}} class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"  required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Fecha fin:</label>
                        <input  onchange="calcularDias();" id="fecha_fin" name="fecha_fin" type="date" {{--min="{{date('Y-m-d');}}"--}} class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Ramo de Seguro:</label>
                        <select name="ramo_de_seguro" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                            <option value="">Seleccione una opción</option>
                            <option value="General">General</option>
                            <option value="Riesgo de trabajo">Riesgo de trabajo</option>
                            <option value="Maternidad">Maternidad</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Días Autorizados:</label>
                        <input onchange="bloqueoCampo();" readonly id="dias_autorizados" name="dias_autorizados" type="number" min="1" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold hidden">Días Acumulados:</label>
                        <input readonly id="dias_acumulados" name="dias_acumulados" type="number" value="{{$dias_acumulados}}" class="hidden py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Nombre del Doctor:</label>
                        <input name="nombre_doctor" type="text" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Matrícula del Doctor:</label>
                        <input name="matricula_doctor" type="text" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Padecimiento:</label>
                        <select name="padecimiento" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($padecimientos as $padecimiento)
                                <option value="{{ $padecimiento->id }}">
                                    {{ $padecimiento->padecimiento_nombre  }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">*Diagnóstico:</label>
                        <textarea id="diagnostico" name="diagnostico" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" type="text" style="max-height: 150px; min-height: 70px;" required/></textarea>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Observaciones:</label>
                        <textarea name="observaciones" class=" py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"/ style="max-height: 150px; min-height: 70px;"></textarea>
                    </div>

                    <div class="grid grid-cols-1 relative">
                        <label for="archivo" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">*Archivo relacionado:</label>
                        <input name="archivo" onchange="validateFile(this);" type="file" accept=".pdf"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" required>

                        <div id="fileError" class="absolute rounded-md bg-red-400 py-3 px-4 mb-5 mt-2" style="top:100%; right: 0%;" hidden>
                            <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                            </svg>
                            <span class="ml-1">Por favor, suba un archivo PDF.</span>
                        </div>
                    </div>

                </div>

                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-8'>
                    <!-- botón cancelar -->
                    <a href="{{ route('datos.index') }}" style="text-decoration:none" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                    <!-- botón enviar -->
                    <button type="submit" class="w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>

<script>
    //Obtener el día actual.
    $(document).ready(function() {
        var date = new Date();
        const minDate = new Date();
        minDate.setDate(minDate.getDate() - 5)   // Margen de 5 días para registrar una incapacidad

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;
        $("#fecha_inicio").attr("value", today);
        $("#fecha_fin").attr("value", today);
        // Agregar valor mínimo para fecha_inicio
        $("#fecha_inicio").attr("min", '2024-07-01'); // Reemplaza "yyyy-mm-dd" con el valor mínimo deseado

        $("#fecha_fin").attr("min", $('#fecha_inicio').val());

        calcularDias();
    });
</script>
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
                    Swal.fire('¡Enviado!', 'El registro ha sido enviado exitosamente.','success');
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
        const fecha_inicio = document.getElementById('fecha_inicio').value;
        const fecha_fin = document.getElementById('fecha_fin').value;

        if (fecha_inicio && fecha_fin && fecha_inicio <= fecha_fin) {
            const inicio_date = new Date(fecha_inicio);
            const fin_date = new Date(fecha_fin);

            const diferenciaMilisegundos = fin_date - inicio_date;

            const diasDiferencia = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24)) + 1;

            document.getElementById('dias_autorizados').value = parseInt(diasDiferencia);
            dias_autorizados = parseInt(diasDiferencia);
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
    function bloqueoCampo() {
        document.getElementById('dias_autorizados').value = dias_autorizados;
        alert("Asigne días estableciendo un periodo de fechas válido.");
    }
</script>
<script>
    //busqueda por RPE
    const SITEURL = "{{ url('/') }}";
    document.getElementById('rpe').addEventListener("input", (e) => {
        if (e.srcElement.value.length >= 5) {
            fetch(`${SITEURL}/incapacidades/crearregistro/buscar?rpe=${e.srcElement.value}`, { method: 'get' })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("solicitante").value = data.datosuser.nombreCompleto;

                    // Actualizar información de la UMF del usuario
                    if(data.datosUMFusuario) {
                        document.getElementById("unidad_medica").selectedIndex = data.datosUMFusuario.unidad;
                        document.getElementById("consultorio").value = data.datosUMFusuario.consultorio;
                        document.getElementById("turno").value = data.datosUMFusuario.turno;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // RPE no encontrado, establece los valores en nulo
                    document.getElementById("rpe").value = "";
                    limpiarDatosAutorellenados();
                });
        } else {
            limpiarDatosAutorellenados();
        }
    });

    function limpiarDatosAutorellenados() {
        document.getElementById("solicitante").value = "";
        document.getElementById("unidad_medica").value = "";
        document.getElementById("consultorio").value = "";
        document.getElementById("turno").value = "";
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
</script>
