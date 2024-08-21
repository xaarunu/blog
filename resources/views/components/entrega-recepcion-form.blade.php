<form class="formEnviar" action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($accion === 'edit')
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 my-4 mx-7">
        <div class="grid grid-cols-1">
            <label for="rpe_ausente"
                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE que se ausentará:</label>
            <input name="rpe_ausente" maxlength="5" type="text" value="{{ old('rpe_ausente') ?? $ausente?->rpe }}" required @if($ausente) readonly @endif
                class="rpe mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />

            <label class="mt-2 uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
            <input id="nombre_ausente" type="text" tabindex="-1" disabled value="{{ $ausente?->getNombreCompleto() }}" readonly
                class="py-2 px-3 rounded-lg border-2 bg-gray-200 border-green-600" />
        </div>
        <div class="grid grid-cols-1">
            <label for="rpe_receptor"
                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE que suplirá:</label>
            <input name="rpe_receptor" maxlength="5" type="text" value="{{ old('rpe_receptor') ?? $receptor?->rpe }}" required @if($accion == 'show') readonly @endif
                class="rpe mt-1 py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />

            <label class="mt-2 uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
            <input id="nombre_receptor" type="text" tabindex="-1" disabled value="{{ $receptor?->getNombreCompleto() }}" readonly
                class="py-2 px-3 rounded-lg border-2 bg-gray-200 border-green-600" />
        </div>
        <div class="grid grid-cols-1">
            <label for="fecha_inicio"
                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha inicio:</label>
            <input name="fecha_inicio" id="fecha_inicio" type="date" value="{{ old('fecha_inicio') ?? $registro?->fecha_inicio }}" @if($accion == 'create') min="{{ Date('Y-m-d') }}" @endif
                required @if($accion == 'show') readonly @endif
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
        </div>
        <div class="grid grid-cols-1">
            <label for="fecha_final"
                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha fin:</label>
            <input name="fecha_final" id="fecha_final" type="date" value="{{ old('fecha_final') ?? $registro?->fecha_final }}" @if($accion == 'create') min="{{ Date('Y-m-d', strtotime('1 day')) }}" @endif
                required @if($accion == 'show') readonly @endif
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
        </div>
        <div class="grid grid-cols-1">
            <label for="motivo"
                class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Motivo:</label>
            <textarea class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                    name="motivo" type="text" required @if($accion == 'show') readonly @endif>{{ old('motivo') ?? $registro?->motivo }}</textarea>
        </div>
        <div class="flex flex-col">
            <label for="archivo" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Archivo relacionado:</label>
            @if($accion == 'show')
                <a target="_blank" class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                    @if($archivo) href="{{ asset($archivo->getFilePath()) }}" @endif>{{ $archivo?->nombre_archivo ?? 'Sin archivo relacionado'}}</a>
            @else
                <input name="archivo" type="file" accept=".pdf" value="{{ old('archivo') }}"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" />
            @endif
        </div>
        <div id="listaRoles" class="grid grid-cols-1 @if(!$roles) hidden @endif">
            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">{{ $accion != 'show' ? 'Roles prestables:' : 'Roles prestados'}}</label>
            <ul class="mb-0">
                {{-- Roles ya seleccionados --}}
                @foreach ($roles as $rol)
                    <li>
                        <input @if($rol?->seleccionado) checked @endif name="roles[]" type="checkbox" value="{{ $rol->id }}" @if($accion == 'show') required disabled @endif />
                        {{ $rol->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- Botones -->
    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-3'>
        <a href="{{ route('recepcion.index') }}" style="text-decoration:none"
            class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">{{ $accion != 'show' ? 'Cancelar' : 'Volver'}}</a>
    @if($accion != 'show')
        <button type="submit"
            class="w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">{{ $accion == 'create' ? 'Guardar' : 'Actualizar'}}</button>
    @endif
    </div>
</form>

<script>
    "use strict";
    const modulo = (function() {
        const SITEURL = "{{ url('/') }}";
        const ListasRoles = { ausente:{}, receptor:{} };
        const rolesElement = document.getElementById('listaRoles');

        document.querySelectorAll('input.rpe').
            forEach((input) => {
                input.addEventListener('input', async (event) => {
                    const { target:entrada } = event;
                    const type = entrada.name.split('_')[1]; // Ausente o receptor
                    
                    if(entrada.value.length >= 5) {
                        try {
                            const response = await getInformacionUser(entrada);
                            const {nombre, roles} = response;

                            document.getElementById(`nombre_${type}`).value = nombre;
                            ListasRoles[type] = roles;
                            mostrarRoles();
                        } catch (error) {
                            console.error('Error:', error);
                            // RPE no encontrado, establece los valores en nulo
                            input.value = "";
                            limpiarNombreyRoles(type);
                        }
                    } else {
                        limpiarNombreyRoles(type);
                    }
                });
            });

        function mostrarRoles() {
            // Unicamente entra cuando ya se encontrarón los roles de ambos usuarios
            if(isRolesLoaded()) {
                let rolesHTML = ``;

                // Obtener roles que no tiene el usuario receptor
                const diferentes = getKeysDiferences(ListasRoles.ausente, ListasRoles.receptor);

                // Si no hay diferencia entre los roles del usuario que se ausentará y el "receptor" mostrar un mensaje
                if(diferentes.length === 0) {
                    rolesHTML = `<li class="text-center">
                                    <span class="text-red-600">No hay roles que se puedan asignar de esta forma.</span>
                                </li>`;
                }

                // Listar diferencia de roles
                diferentes.forEach((key) => {
                    rolesHTML +=
                        `<li>
                            <input name="roles[]" type="checkbox" value="${key}" />
                                ${ListasRoles.ausente[key]}
                        </li>`;
                })

                // Añadir checkboxes en la lista (ul) de roles y mostrar el div
                rolesElement.lastElementChild.innerHTML = rolesHTML;
                rolesElement.classList.remove('hidden');
            }
        }

        function isRolesLoaded() {
            // El objeto de "ListasRoles" debe tener dos listas que tengan más de 1 rol cada una
            return Object.keys(ListasRoles.ausente).length > 0 && Object.keys(ListasRoles.receptor).length > 0;
        }

        function getKeysDiferences(obj1, obj2) {
            return Object.keys(obj1).filter(key => !Object.keys(obj2).includes(key));
        }

        function limpiarNombreyRoles(input) {
            document.getElementById(`nombre_${input}`).value = "";
            ListasRoles[input] = [];
            rolesElement.classList.add('hidden');
        }

        async function getInformacionUser(input) {
            return fetch(`${SITEURL}/buscar-user/${input.value}`, { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    // Calcular nombre completo y mostrarlo en el respectivo input
                    const nombreCompleto = [data.nombre, data.paterno, data.materno].join(' ');

                    return {
                        nombre: nombreCompleto,
                        roles: data.roles,
                    };
                })
                .catch(error => { throw error; });
        }

        return {
            getInformacionUser,
            ListasRoles,
        }
    })();
</script>
<script>
    (function() {
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFinal = document.getElementById('fecha_final');
        
        fechaInicio.addEventListener('change', () => validarFechas());
        fechaFinal.addEventListener('change', () => validarFechas());

        function validarFechas() {
            const inicio = new Date(fechaInicio.value).getTime();
            const final = new Date(fechaFinal.value).getTime();
            
            // En caso que se seleccione una fecha final anterior a la fecha de inicio
            if(!final || inicio >= final) {
                // Calcular nuevo día minimo para la fecha final
                const diaposterior = new Date(fechaInicio.value);
                diaposterior.setDate(diaposterior.getDate() + 1);

                // Setear la nueva fecha calculada
                fechaFinal.setAttribute('min', diaposterior.toISOString().substr(0, 10));
                fechaFinal.value = diaposterior.toISOString().substr(0, 10);
            }
        }
    })();
</script>