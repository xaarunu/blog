<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <form id="formEnviar" action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($accion != 'create')
                @method('PUT')
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE:</label>
                    <input name="rpe" type="text" maxlength="5" value="{{ old('rpe') ?? $user?->rpe }}" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        required />
                    @error('rpe')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">email:</label>
                    <input name="email" value="{{ old('email') ?? $user?->email }}" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        type="text" required />
                    @error('email')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                    <input name="nombre" value="{{ old('nombre') ?? $datos?->nombre }}" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        type="text" required />
                    @error('nombre')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="grid grid-cols-1">
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido
                        Paterno:</label>
                    <input name="paterno" value="{{ old('paterno') ?? $datos?->paterno }}" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        type="text" required />
                    @error('paterno')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="grid grid-cols-1">
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido
                        Materno:</label>
                    <input name="materno" value="{{ old('materno') ?? $datos?->materno }}" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        type="text" required />
                    @error('materno')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="grid grid-cols-1">
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                        Antigüedad:</label>
                    <input name="ingreso" type="date" value="{{ old('ingreso') ?? $datos?->antiguedad }}" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                        type="text" required />
                    @error('ingreso')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Contrato:</label>
                    <select name="contrato" id="contrato" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option id="SINDICALIZADO TEMPORAL" @if(old('contrato') == "7") selected @endif value="7">
                            SINDICALIZADO TEMPORAL
                        </option>
                        <option id="SINDICALIZADO BASE" @if(old('contrato') == "6") selected @endif value="6">
                            SINDICALIZADO BASE
                        </option>
                        <option id="CONFIANZA TEMPORAL" @if(old('contrato') == "2") selected @endif value="2">
                            CONFIANZA TEMPORAL
                        </option>
                        <option id="CONFIANZA BASE" @if(old('contrato') == "1") selected @endif value="1">
                            CONFIANZA BASE
                        </option>
                        <option id="JUBILADO" @if(old('contrato') == "3") selected @endif value="3">
                            JUBILADO
                        </option>
                        <option id="BAJA" @if(old('contrato') == "4") selected @endif value="4">
                            BAJA
                        </option>
                    </select>
                </div>

                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">PUESTO:</label>
                    <select id="_puesto" name="puesto" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required>
                        @foreach (App\Models\Puesto::all() as $puesto)
                            <option id="{{ $puesto->id }}" value="{{ $puesto->nombre_puesto }}"
                                @if(old('puesto') == $puesto->nombre_puesto)
                                    selected
                                @elseif($datos?->puesto == $puesto->nombre_puesto)
                                    selected
                                @endif >
                                {{ $puesto->nombre_puesto }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">División:</label>
                    <select id="_divisiones" name="division" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required>
                        @foreach ($divisiones as $division)
                            <option id="{{ $division->division_clave }}"
                                value="{{ $division->division_clave }}"
                                @if(old('division') == $division->division_clave)
                                    selected
                                @elseif($datos?->division == $division->division_clave)
                                    selected
                                @endif >
                                {{ $division->division_nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1">
                    <label
                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Área:</label>
                    <select id="_areas" name="area" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required />
                    @foreach ($areas as $area)
                        <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}"
                            @if(old('area') == $area->area_clave)
                                selected
                            @elseif($datos?->area == $area->area_clave)
                                selected
                            @endif >
                            {{ $area->area_nombre }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1">
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Subárea:</label>
                    <select name="subarea" id="_subareas" @if($accion == 'show') disabled @endif
                        class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @foreach ($subareas as $subarea)
                            <option id="{{ $subarea->subarea_clave }}" value="{{ $subarea->subarea_clave }}"
                                @if(old('subarea') == $subarea->subarea_clave)
                                    selected
                                @elseif($datos?->subarea == $subarea->subarea_clave)
                                    selected
                                @endif >
                                {{ $subarea->subarea_nombre }}</option>
                        @endforeach
                    </select>
                </div>

                @if($accion == 'create')
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Contraseña:</label>
                        <input name="password" id = "password" type="password" value="{{ old('password') }}" autocomplete="on"
                            placeholder="Si se deja en blanco se configura contraseña default"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                            />
                        @error('password')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
            </div>
            <br>
            <center>
                <table id="data-table" class="grid grid-cols-1 place-items-center"
                    style= "width:50%; padding-top: 1em;  padding-bottom: 1em; border-spacing: 5px;
                    border-collapse: separate;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Roles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr data-id="{{ $role->name }}">
                                <td>
                                    <input type="checkbox" name="roles[]"
                                        value="{{ $role->name }}" @if($accion == 'show') disabled @endif
                                        @if ($user?->hasRole($role)) checked=checked @endif />
                                </td>
                                <td style="text-align:justify;">
                                    {{ $role->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </center>
            <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
            @if($accion != 'show')
                <a href="{{ route('users.index') }}"
                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                <button type="submit"
                    class='w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
            @else
                {{ $slot }}
            @endif
            </div>
        </form>
    </div>
</div>

<script>
    const con = document.getElementById('contrato');
    const datos = @json($datos);

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const SITEURL = "{{ url('/') }}";


    document.getElementById('_areas').addEventListener('change', (e) => {
        fetch(SITEURL + '/subarea', {
            method: 'POST',
            body: JSON.stringify({
                area: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lsubarea) {
                opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("_subareas").innerHTML = opciones;
        }).catch(error => alert(error));
    })

    document.getElementById('_divisiones').addEventListener('change', (e) => {
        fetch(SITEURL + '/areas', {
            method: 'POST',
            body: JSON.stringify({
                division: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lareas) {
                opciones += '<option value="' + data.lareas[i].area_clave + '">' + data.lareas[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("_areas").innerHTML = opciones;

            fetch(SITEURL + '/subareas', {
                method: 'POST',
                body: JSON.stringify({
                    area: data.lareas[0].area_clave,
                    "_token": "{{ csrf_token() }}"
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                },
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "";
                for (let i in data.lsubarea) {
                    opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data
                        .lsubarea[i].subarea_nombre + '</option>';
                }
                document.getElementById("_subareas").innerHTML = opciones;
            }).catch(error => alert(error));

        }).catch(error => alert(error));
    })

    function changeRole(id) {
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        var rol = document.getElementById(id + 'select').value;
        fetch('users/' + id, {
            method: 'PUT',
            body: JSON.stringify({
                rol: rol,
                origen: 'fetch',
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).catch(error => alert(error));
    }
</script>

<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        const loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
        const forms = document.querySelectorAll('.formEnviar')

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
    // En caso de contar con datos, seleccionar el contrato correcto
    if(datos) {
        Array.from(con.options).forEach((element, index) => {
            if (element.value == datos.contrato) {
                con.selectedIndex = index;
            }
        });
    }
</script>