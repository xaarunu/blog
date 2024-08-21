{{-- El Santo, el Cavernario, Blue Demond y el Buldog --}}
<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Expediente ProSalud') }}
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
                <form id="form_update" action="{{ route('salud.actualiza') }}" method="POST" class="formEnviar" enctype="multipart/form-data">
                    <div  id="datos_usuario">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-8 mt-5 mb-2 mx-7">
                            <div class="grid grid-cols-1 relative">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE:</label>
                                <input readonly id="rpe" name="rpe" value="{{$expediente->rpe}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500   mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    type="text" minlength="0" maxlength="5" autocomplete="off" required/>
                                    <ol id="recomendaciones_RPE" class="absolute shadow bg-white border border-green-600 rounded w-full grid grid-rows-5 divide-y divide-green-500 text-blue-900 hidden" style="top: 105%;">
                                    </ol>
                            </div>
                                <input id="id" name="id" value="{{$expediente->id}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500   mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    type="text" minlength="0" maxlength="5" autocomplete="off" hidden/>
                            <div class="grid grid-cols-1 relative">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
                                <input readonly id="nombre" name="nombre" value="{{$expediente->nombre}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    type="text" required/>
                                    <ol id="recomendaciones_Nombre" class="absolute shadow bg-white border border-gray-600 rounded w-full grid grid-rows-5 divide-y divide-gray-500 text-blue-900 hidden" style="top: 105%;">
                                    </ol>
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Toma:</label>
                                <input id="fecha_toma" name="fecha_toma" value="{{$expediente->fecha_toma}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    type="date" required />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Edad:</label>
                                <input id="edad" name="edad" value="{{$expediente->edad}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    type="number"  min="0" max="100" step="1" required />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Glucosa: </label>
                                <input id="glucosa_resultado" name="glucosa_resultado" value="{{$expediente->glucosa_resultado ?? ''}}"
                                class="py-2 px-3 text-black rounded-lg border-2  border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent "
                                    type="text" />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Trigliceridos:</label>
                                <input id="trigliceridos_resultado" name="trigliceridos_resultado" value="{{$expediente->trigliceridos_resultado ?? ''}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent "
                                    type="text" />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado del Colesterol:</label>
                                <input id="colesterol_resultado" name="colesterol_resultado" value="{{$expediente->colesterol_resultado ?? ''}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent  "
                                    type="text" />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de la Hemoglobina:</label>
                                <input id="hemoglobina_resultado" name="hemoglobina_resultado" value="{{$expediente->hemoglobina_resultado ?? ''}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent "
                                    type="text" />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Leucocitos:</label>
                                <input id="leucocitos_resultado" name="leucocitos_resultado" value="{{$expediente->leucocitos_resultado ?? ''}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent "
                                    type="text" />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Resultado de Plaquetas:</label>
                                <input id="plaquetas_resultado" name="plaquetas_resultado" value="{{$expediente->plaquetas_resultado ?? ''}}"
                                class="py-2 px-3 text-black rounded-lg border-2 border-green-500  mt-1 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent "
                                    type="text" />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Zona:</label>
                                <select id="zona" name="zona"
                                    class="block py-2 px-3 text-black rounded-lg border-2 border-green-500 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="" required>Seleccione una opción</option>
                                    @foreach ($zonas as $zona)
                                            <option value="{{ $zona->area_clave }}" {{ $expediente->zona == $zona->area_clave ? 'selected' : '' }}>
                                                {{ $zona->area_nombre }}
                                            </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <!-- botón cancelar -->
                        <a href="{{ url()->previous() }}" style="text-decoration: none"
                            class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                        <!-- botón enviar -->
                            <button type="submit" class="rounded-lg bg-green-500 hover:bg-green-700 font-medium text-black px-4 py-2">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('rpe').addEventListener('input', async (e) => {
            if(e.target.value !== "" && e.target.value.length >= 3){
                let rpe = e.target.value;
                const url = "{{ route('capacitacion.findUser') }}";
                const data = {
                    rpe: rpe,
                };
                buscar('GET', data, url, rpes);
            }
    });
</script>
<script>
document.getElementById('nombre').addEventListener('input', async (e) => {
    let nombre = e.target.value;
    console.log(nombre);
    if (nombre !== "" && nombre.length >= 3) {
        const url = "{{ route('capacitacion.buscarNombre') }}";
        const data = {
            query: nombre,
        };
        buscar('GET', data, url, nombres);
    }
});

const rpes = (response) => {
    console.log(response);
    console.log('Entra para insertar nombres');
    const recomendacionesRPE = document.getElementById('recomendaciones_RPE');
    recomendacionesRPE.innerHTML = '';
    if(response.success) {
        response.coincidencias.forEach((item) => {
            console.log(item);

            let chi = document.createElement('li');
            let rpe = item.nombre + " " + item.paterno + " " + item.materno;
            var YOLO = document.getElementById('recomendaciones_RPE');
            YOLO.classList.remove('hidden');
            chi.className = 'flex items-center gap-1 p-1 cursor-pointer hover:bg-gray-100';
            chi.textContent = `${item.rpe}`
            recomendacionesRPE.appendChild(chi);
            chi.addEventListener('click', () => {
                document.getElementById('rpe').value = chi.textContent;
                document.getElementById('nombre').value = rpe;
                YOLO.classList.add('hidden');
                recomendacionesRPE.innerHTML = '';
            });
        });
    } else {
        let li = document.createElement('li');
        li.className = 'flex items-center gap-1 p-1';
        li.textContent = 'No se encontraron coincidencias';
        recomendacionesRPE.appendChild(li);
    }
}

const nombres = (response) => {
    console.log(response);
    console.log('Entra para insertar nombres');
    const recomendacionesNombre = document.getElementById('recomendaciones_Nombre');
    recomendacionesNombre.innerHTML = '';
    if(response.success) {
        response.coincidencias.forEach((item) => {
            let li = document.createElement('li');
            let rpe = item.rpe;
            var lista = document.getElementById('recomendaciones_Nombre');
            lista.classList.remove('hidden');
            li.className = 'flex items-center gap-2 p-2 cursor-pointer hover:bg-gray-100';
            li.textContent = `${item.nombre}  ${item.paterno} ${item.materno}`;
            recomendacionesNombre.appendChild(li);
            li.addEventListener('click', () => {
                document.getElementById('nombre').value = li.textContent;
                document.getElementById('rpe').value = rpe;
                lista.classList.add('hidden');
                recomendacionesNombre.innerHTML = '';
            });
        });
    } else {
        let li = document.createElement('li');
        li.className = 'flex items-center gap-2 p-2';
        li.textContent = 'No se encontraron coincidencias';
        recomendacionesNombre.appendChild(li);
    }

    };
    document.addEventListener('click', function(event) {
    var lista = document.getElementById('recomendaciones_Nombre');
    if (!lista.contains(event.target) && !event.target.closest('button')) {
        lista.classList.add('hidden');
    }
    });
    const buscar = (type, data, url, funcionDinamica) => {
        const token = '{{ csrf_token() }}';
        data._token = token;
        $.ajax({
            type,
            data,
            url,
            success: funcionDinamica,
            error: (xhr, status, error) => {
                console.log('Error al buscar:', error);
            },
        });
    };
</script>

