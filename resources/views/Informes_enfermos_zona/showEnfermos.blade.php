
<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Informe de padecimientos del personal
        </h2>
    </x-slot>


    <x-boton-regresar />

    <div class="alert" id="elementoOculto" style=" display: none; color: #571515; background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
        <p>No hay datos disponibles para mostrar en la gráfica.</p>
    </div>

    <div class="w-full flex justify-center items-center">
        <div class="card mt-4 px-2 py-2 mx-4 rounded-lg shadow-lg m-4"
            style="background-color: white; width: 1200px; height: 1000;">
            <div class="text-center p-4">
                <div class="flex flex-col md:flex-row mb-3 gap-4">
                    <!-- División -->
                    @php $mostrarDivision = Auth::user()->hasAnyRole(['admin', 'Doctora']); @endphp
                    <div class="flex-grow grid grid-cols-1 @if(!$mostrarDivision) hidden @endif">
                        <label class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">División:</label>
                        <select id="divisionFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @if($mostrarDivision)
                                @foreach ($divisiones as $division)
                                    <option @if($division->division_clave == Auth::user()->datos->getDivision->division_clave) selected @endif value="{{ $division->division_clave }}">{{ $division->division_nombre }}</option>
                                @endforeach
                            @else
                                <option selected value="{{ Auth::user()->datos->getDivision->division_clave }}"></option>
                            @endif
                        </select>
                    </div>
                    <!-- Área -->
                    <div class="flex-grow grid grid-cols-1">
                        <label class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Área:</label>
                        <select id="areaFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @can('controlDivisional')
                                <option value="all">Todas las áreas</option>
                                @foreach ($areas as $area)
                                    <option @if ($area->area_clave == Auth::user()->datos->getArea->area_clave) selected @endif value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                @endforeach
                            @else
                                <option value="{{ Auth::user()->datos->getArea->area_clave }}">{{ Auth::user()->datos->getArea->area_nombre}}</option>
                            @endcan
                        </select>
                    </div>
                    <!-- Subárea -->
                    <div class="flex-grow grid grid-cols-1">
                        <label class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Subárea:</label>
                        <select id="subareaFilter"
                            class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="all">Todas las subáreas</option>
                            @foreach($subareas as $subarea)
                                @if (strpos($subarea->area->area_clave, 'DX') === 0)
                                    <option value="{{ $subarea->subarea_clave }}"
                                        data-area="{{ $subarea->area_id }}">{{ $subarea->subarea_nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <!-- Filtro para Fechas -->
                    <div class="flex-grow grid grid-cols-1">
                        <label for="filtro_dia_inicio" class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold ">Fecha Inicio</label>
                        <input id="filtro_dia_inicio" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date" value="{{now()->format('Y-m-d')}}" />
                    </div>
                    <div class="flex-grow grid grid-cols-1">
                        <label for="filtro_dia_fin" class="text-start md:text-center uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin</label>
                        <input id="filtro_dia_fin" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date" value="{{now()->format('Y-m-d')}}" />
                    </div>
                    <!-- Botón -->
                    <div class="flex-grow self-end mx-auto md:self-center">
                        <button onClick="filter()" style="text-decoration:none;"
                        class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3">Filtrar</button>
                    </div>
                </div>
            </div>
            <!-- Gráfica de pastel -->
            <center>
                <div id="canvasContainer" style="width: 60%; height:50%; position: relative;">
                    <canvas id="enfermosChart"></canvas>
                    <div class="message-overlay" id="noDataMessage" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; display: none;">
                        <p>No hay datos disponibles para mostrar en la gráfica.</p>
                    </div>
                </div>
            </center>

        </div>
    </div>
</x-app-layout>

<script>
    // Accede a los datos pasados desde Laravel
    var usuariosEnfermosFormatted = @json($usuariosEnfermosFormatted);
    // Llama a tu función updateChart con la variable de JavaScript
    $(document).ready(function() {
        // Código que se ejecutará cuando el DOM esté listo
        updateChart(usuariosEnfermosFormatted); // Asume que tu función updateChart toma un parámetro de datos.
    });
</script>


<script src={{asset('plugins/chart/Chart.min.js')}}></script>

<script>
    var ctx = document.getElementById('enfermosChart').getContext('2d');
    const etiquetasEnfermedades = @json($etiquetasEnfermedades);
    var chart;  // Declarar la variable chart aquí
    // Filtrar los datos según el área y subárea seleccionadas
    var areaFilter = document.getElementById('areaFilter');
    var subareaFilter = document.getElementById('subareaFilter');
    // Filtrar los datos según el área y subárea seleccionadas
    var areaFilter = document.getElementById('areaFilter');
    var subareaFilter = document.getElementById('subareaFilter');
    // Actualiza la gráfica cuando se selecciona una nueva área o subárea
    // Función para actualizar la gráfica
    function updateChart(data) {
        var filteredUsers = data;
        // Crea una matriz con el número de usuarios por enfermedad
        var usersByDisease = {};
        // Define el orden deseado de etiquetas
         var etiquetasDeseadas = etiquetasEnfermedades;
        etiquetasDeseadas.forEach(function (enfermedad) {
            usersByDisease[enfermedad] = 0;
        });
        // Actualiza el objeto con los usuarios encontrados
        if (filteredUsers && filteredUsers.length > 0) {
            // Ocultar mensaje de "sin datos"
            document.getElementById('noDataMessage').style.display = 'none';

            // Itera sobre el array solo si tiene elementos
            filteredUsers.forEach(function(user) {
                var disease = user.enfermedad;
                usersByDisease[disease] = 1;
                // Establece en 1 para usuarios enfermos
            });
        } else {
            // Muestra el mensaje de no hay resultados que graficar
            document.getElementById('noDataMessage').style.display = 'block';
        }
        // Destruye la gráfica existente antes de actualizarla
        if (chart) {
            chart.destroy();
        }
        // Filtra los datos en el orden deseado
        var etiquetas = etiquetasDeseadas.map(function (enfermedad) {
            return enfermedad;
        });
        // Crea una nueva gráfica de pastel con los datos filtrados
        chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: etiquetas,
                datasets: [{
                    data: Object.values(usersByDisease).map(function (value) {
                        return value ? value : 0;
                    }),
                    backgroundColor: [
                        '#239058', '#81aeab', '#648ba4', '#55a77f', '#a1c2c0', '#719f9b', '#c0d3dc', '#98deb9', '#628f8c', '#bbe2e8', '#f4dcbc'
                    ]
                }]
            }
        });
    }
    // Inicializar la gráfica con los datos sin filtrar
    updateChart();

</script>


{{-- Scrip de filtros --}}
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const SITEURL = "{{ url('/') }}";
    function filter() {

        var division = document.getElementById('divisionFilter').value;
        var areaFilter = document.getElementById('areaFilter').value;
        var subareaFilter = document.getElementById('subareaFilter').value;
        // var subareas = Array.from(subareaFilter.options);
        fetch(SITEURL + '/filtrarUsuariosEnfermedades',{
            method: 'POST',
            body: JSON.stringify({
                division: division,
                area: areaFilter,
                subarea: subareaFilter,
                fechaInicial: document.getElementById('filtro_dia_inicio').value,
                fechaFinal: document.getElementById('filtro_dia_fin').value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            if (!response.ok) {
                throw new Error('error');

            } else
                return response.json()
        }).then(data => {
            if (data.users.length === 0) {
                elementoOculto.style.display = "block"; // Mostrar el mensaje
                setTimeout(function () {
                    elementoOculto.style.display = "none"; // Ocultar el mensaje después de 3 segundos
                }, 3000);
            }
            updateChart(data.users); // Llama a la función de actualización con los datos recibidos
        });
    }
</script>
<script>
    //Actualizar areas select dependiendo de la división
    document.getElementById('divisionFilter').addEventListener('change', (e) => {
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
            let opciones = "<option value='all' style='color: blue;'>Todas las áreas</option>";
            for (let i in data.lareas) {
                opciones += '<option value="' + data.lareas[i].area_clave + '">' + data.lareas[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("areaFilter").innerHTML = opciones;

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
                var opciones = "<option value='all' style='color: blue;'>Todas las subáreas</option>";
                for (let i in data.lsubarea) {
                    opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data
                        .lsubarea[i].subarea_nombre + '</option>';
                }
                document.getElementById("subareaFilter").innerHTML = opciones;
            }).catch(error => alert(error));

        }).catch(error => alert(error));
    })
</script>
<script>
    //Actualizar subareas select dependiendo el area
    document.getElementById('areaFilter').addEventListener('change', (e) => {
        fetch(SITEURL + '/subareas', {
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
            var opciones = "<option value='all' style='color: blue;'>Todas las subáreas</option>";
            for (let i in data.lsubarea) {
                opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("subareaFilter").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
