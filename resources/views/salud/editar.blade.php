<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            {{ __('Nota Médica') }}

        </h2>
    </x-slot>

    <!-- Scripts para ampliar las imagenes -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css" rel="stylesheet"/>


    <x-boton-regresar />

    @if ($errors->any())
        <div class="mt-4 p-5 text-center bg-red-500 w-3/5 mx-auto rounded shadow-md text-white">
            <h5 class="text-xl">Ocurrio un error, verifica la información ingresada</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-base">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="px-10 pb-3 leading-normal max-w-7xl mx-auto">
            <div class="text-right">
                <button id="btnHabilitar" onclick="habilitarEdicion();" class="bg-gray-500 hover:bg-green-600 rounded-lg shadow-xl font-medium text-white px-10 py-2">Habilitar edición</button>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-10 lg:px-10">
            <form action="{{route('saluds.update', $miSalud->id)}}" method="POST" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-4 gap-5 md:gap-8 mt-5 mx-7">
                    <div style="grid-column-start:1; grid-column-end:5" class="grid grid-cols-5 gap-5 md:gap-8">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">RPE:</label>
                            <input disabled name="rpe" value="{{$miSalud->rpe}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Fecha Nacimiento:</label>
                            <input disabled name="fecha_nacimiento" value="{{$miSalud->fecha_nacimiento}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Fecha:</label>
                            <input disabled name="fecha" value="{{$miSalud->fecha}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Hora:</label>
                            <input disabled name="hora" value="{{$miSalud->hora}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Sexo:</label>
                            <input disabled name="sexo" value="{{$miSalud->sexo}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Peso:</label>
                            <input disabled name="peso" value="{{$miSalud->peso}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Altura:</label>
                            <input disabled name="altura" value="{{$miSalud->altura}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">imc:</label>
                            <input readonly name="imc" value="{{$miSalud->imc}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Medida de cintura:</label>
                            <input disabled name="cintura" value="{{$miSalud->cintura}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Medida de cadera:</label>
                            <input disabled name="cadera" value="{{$miSalud->cadera}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Presion arterial:</label>
                            <div class="grid grid-cols-3">
                                <input disabled name="presionSis" value="{{$miSalud->presionSis}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                                <input disabled name="none" value="/" style="text-align:center; font-size:20px" class="font-bold py-1 px-3 justify-items-center justify-center  border-transparent mt-1" type="text"/>
                                <input disabled name="presionDia" value="{{$miSalud->presionDia}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"  type="text" required/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Temperatura:</label>
                            <input disabled name="temperatura" value="{{$miSalud->temperatura}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Nivel de saturación:</label>
                            <input disabled name="saturacion" value="{{$miSalud->saturacion}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Nivel de glucosa:</label>
                            <input disabled name="glucosa" value="{{$miSalud->glucosa}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Frecuencia cardiaca:</label>
                            <input disabled name="cardiaca" value="{{$miSalud->cardiaca}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Frecuencia respiratoria:</label>
                            <input disabled name="respiratoria" value="{{$miSalud->respiratoria}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Alergias:</label>
                        <input disabled name="alergias" value="{{$miSalud->alergias}}" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Descripción de alergía:</label>
                        <textarea disabled name="tipo" style="resize:none" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required>{{$miSalud->tipo}}</textarea>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Enfermedades Cronicas:</label>
                        <div disabled name="padecimientos" rows="3" style="resize:none" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required>
                            @foreach ($datos as $dato)
                                <div>{{$dato}}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Observaciones:</label>
                        <textarea disabled name="observaciones" rows="3" style="resize:none" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="textarea" required> {{$miSalud->observaciones}}</textarea>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-black-500 text-light font-semibold">Diagnostico:</label>
                        <textarea disabled name="diagnostico" rows="3" style="resize:none" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required> {{$miSalud->diagnostico}}</textarea>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tratamiento:</label>
                        <textarea disabled name="tratamiento" rows="3" style="resize:none" class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" type="text" required>{{$miSalud->tratamiento}}</textarea>
                    </div>
                    @isset($archivo)
                    <div class="grid grid-cols-1 ">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Archivos adjuntos:</label>
                        <div disabled style="resize:none" class="py-7 px-5 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                            @foreach ($archivo as $i => $archi)
                                <a href="{{ $archivo[$i]->archivo }}" target="_blank">{{ $archivo[$i]->nombre}}</a><hr/>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5">
                    <a href="{{ route('saluds.indice', $miSalud->rpe) }}" class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <button id="btnEditar" class="btn rounded-lg bg-green-600 hover:bg-green-700 text-black font-bold py-2 px-4" type="submit" hidden disabled>Editar</button>
                    <button id="btnEliminar" type="button" class="font-bold py-2 px-4 rounded-lg bg-red-600 hover:bg-red-700" onclick="eliminarExpediente();">Borrar</button>
                </div>
            </form>
            <form id="deleteForm" action="{{ route('saluds.destroy', $miSalud->id) }}" method="POST" class="formEliminar">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
{{-- <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
                <div id="caption"></div>
            </div> --}}
</x-app-layout>

<script>
    (function () {
      'use strict'
      //debemos crear la clase formEliminar dentro del form del boton borrar
      //recordar que cada registro a eliminar esta contenido en un form
      var loader = document.getElementById("preloader");    //Se guarda el loader en la variable.
      var forms = document.querySelectorAll('.formEliminar')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
              event.preventDefault()
              event.stopPropagation()
              Swal.fire({
                    title: '¿Confirma la eliminación del registro? ' + ' Se eliminaran los estudios adjuntos',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#20c997',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Confirmar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                        Swal.fire('¡Eliminado!', 'El registro ha sido eliminado exitosamente.','success');
                    }
                else {
                    //Se oculta el loader para que no tape toda la pantalla por siempre.
                    loader.style.display = "none";
                }
                })
          }, false)
        })
    })()
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
        var peso = document.querySelector('[name="peso"]').value;
        var altura = document.querySelector('[name="altura"]').value;

        var imc = peso / (altura * altura);

        document.querySelector('[name="imc"]').value = imc.toFixed(1);
    };
</script>

<script>
    const camposEditables = ["peso", "altura", "cintura", "cadera",
    "presionSis", "presionDia", "temperatura", "saturacion", "glucosa",
    "cardiaca", "respiratoria", "alergias", "tipo", "padecimientos", "observaciones",
    "diagnostico", "tratamiento"];

    function habilitarEdicion() {
        document.querySelector('[name="rpe"]').removeAttribute('disabled');
        document.querySelector('[name="rpe"]').setAttribute('readonly', true);

        for(const campo of camposEditables) {
            const input = document.querySelector(`[name="${campo}"]`);

            input.removeAttribute('disabled');
            input.classList.add('border-green-500');
        }

        // Actualización de botones
        document.getElementById('btnHabilitar').setAttribute('disabled', true);
        document.getElementById('btnHabilitar').classList.remove('bg-gray-500');
        document.getElementById('btnHabilitar').classList.add('bg-green-500');
        document.getElementById('btnHabilitar').textContent = "Edición Habilitada";

        document.getElementById('btnEditar').removeAttribute('hidden');
        document.getElementById('btnEditar').removeAttribute('disabled');

        document.getElementById('btnEliminar').setAttribute('hidden', true);
        document.getElementById('btnEliminar').setAttribute('disabled', true);
    }
</script>

<script>
    function eliminarExpediente() {
        document.getElementById('deleteForm').submit();
    }
</script>
