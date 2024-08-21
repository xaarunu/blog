<x-app-layout>
    @section('title', 'DCJ - CFE: Audiometrías')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Registrar Audiometría') }}</h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    @endsection

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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form class="formEnviar" action="{{ route('audiometrias.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 my-4 mx-7">
                        <div class="grid grid-cols-1">
                            <label for="rpe"
                                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE:</label>
                            <input name="rpe" id="rpe" maxlength="5" type="text" required
                                @if($datosuser) value="{{ $datosuser->rpe }}" readonly @endif
                                class="mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label for="nombreCompleto"
                                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
                            <input name="nombreCompleto" id="nombreCompleto" type="text" readonly tabindex="-1"
                                disabled class="mt-1 py-2 px-3 rounded-lg border-2 border-green-600"
                                value="{{ $nombreCompleto }}">
                        </div>
                        <div class="grid grid-cols-1">
                            <label for="oido_izquierdo"
                                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Oido izquierdo:</label>
                            <select name="oido_izquierdo" id="oido_izquierdo" required
                                class="mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent">
                                <option selected disabled hidden>Selecciona un resultado</option>
                                @foreach ($resultados as $resultado)
                                    <option value="{{ $resultado->id }}">{{ $resultado->diagnostico }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label for="oido_derecho"
                                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Oido derecho:</label>
                            <select name="oido_derecho" id="oido_derecho" required
                                class="mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent">
                                <option selected disabled hidden>Selecciona un resultado</option>
                                @foreach ($resultados as $resultado)
                                    <option value="{{ $resultado->id }}">{{ $resultado->diagnostico }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label for="fecha_toma"
                                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha de
                                estudio:</label>
                            <input name="fecha_toma" id="fecha_toma"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="date" required />
                        </div>
                        <div class="grid grid-cols-1 position-relative">
                            <label for="archivo" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Archivo
                                relacionado:</label>
                            <input name="archivo" onchange="validateFile(this)" type="file" accept=".pdf" required
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent">

                            <div id="fileError" class="position-absolute alert alert-danger mt-2 mb-7" style="top:100%;" role="alert" hidden>
                                <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                                </svg>
                                <span class="ml-1">Por favor, suba un archivo PDF, DOC o DOCX.</span>
                            </div>
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-3'>
                        <a href="{{ route('audiometrias.index') }}" style="text-decoration:none"
                            class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                        <button type="submit"
                            class="w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const validFileExtensions = ["pdf", "doc", "docx"];
    const calendario = document.getElementById('fecha_toma');
    const SITEURL = "{{ url('/') }}";

    // Setear el día actual como la fecha maxima posible para registrar en una audiometría
    calendario.setAttribute('max', new Date().toISOString().slice(0, 10));

    document.getElementById('rpe').addEventListener("input", (e) => {
        if (e.srcElement.value.length >= 5) {
            fetch(`${SITEURL}/audiometrias/crearregistro/buscar?rpe=${e.srcElement.value}`, {
                    method: 'get'
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("nombreCompleto").value = data.datosuser.nombreCompleto;
                })
                .catch(error => {
                    console.error('Error:', error);
                    // RPE no encontrado, establece los valores en nulo
                    document.getElementById("nombreCompleto").value = "";
                    document.getElementById("rpe").value = "";
                });
        } else {
            document.getElementById("nombreCompleto").value = "";
        }
    });

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
