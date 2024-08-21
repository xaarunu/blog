<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($periodo_fecha))
                Ranking de {{ $tematica }} por zona {{ $periodo_fecha }}.
            @else
                Ranking de {{ $tematica }} por zona Período: {{ $fechaInicioPeriodo }} - {{ $fechaFinPeriodo }}.
            @endif
        </h2>
    </x-slot>
    @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/boxicons/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glightbox/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endsection

    <script src="{{ asset('js/aos/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>

    <x-boton-regresar />

    <div class="alert" id="elementoOculto" style=" display: none; color: #571515; background-color: #edd4d4; border: 1px solid #e6c3c3; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border-radius: 10px; margin: 10px;">
        <p>No hay datos disponibles para mostrar.</p>
    </div>
    <div class="w-full flex justify-center items-center ">
        <div class="text-center p-4">
            <div class="flex flex-row mb-3">
                <form action="{{ route('ranking.filtro') }}" method="POST" id="filtroForm">
                @csrf
                <div class="flex flex-row mb-3">
                <div  class="mr-4">
                    <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold mr-3">Tematica:</label>
                    <select id="tematicaFilter" name="tematica"
                        class="py-2 px-5 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="incapacidades">Incapacidades</option>
                        <option value="enfermos">Enfermos</option>
                        <option value="notasMedicas">Notas médicas</option>
                    </select>
                </div>
                <div  class="mr-4">
                    <label for="filtro_dia_inicio" class="block uppercase md:text-sm text-xs text-gray-500 font-semibold ">Fecha Inicio</label>
                    <input id="filtro_dia_inicio" name="fecha_inicio" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date" value="{{now()->format('Y-m-d')}}" />
                </div>

                <div  class="mr-4" >
                    <label for="filtro_dia_fin" class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha Fin</label>
                    <input id="filtro_dia_fin" name="fecha_fin" class="py-2 px-3 rounded-lg border-2 border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" type="date" value="{{now()->format('Y-m-d')}}" />
                </div>
                <br>
                <div class="grid grid-rows-1 place-items-center mt-3">
                    <!-- botón Filtrar -->
                        <!-- ---------------------------------------------------------------------------------------------->
                    <button type="submit" style="text-decoration:none;"
                    class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
                        <!-- ---------------------------------------------------------------------------------------------->
                </div>
                <br>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mx-auto sm:px-6 lg:px-8 mt-4 mb-5" style="width:80rem;">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
            <div class="flex justify-center items-end mt-5">
                <a href="" id="segundo" onclick="asig('segundo', '{{ $first[1]['area'] }}')">
                    <div class="tarjeta segundo-puesto @if($first[1]['color'] =='verde') verde @elseif($first[1]['color'] =='amarillo') amarillo @else rojo @endif">
                        <img src="{{ asset('img/segundolugar.png') }}" class="segundo mb-2" alt="User Img">
                        <div class="font-bold text-4xl mt-9">Segundo Lugar</div>
                        <div class="font-bold text-2xl mt-4">{{ $first[1]['area'] }}</div>
                        <div class="font-bold text-xl mt-4">Cantidad de Enfermos: {{ $first[1]['cantidad_registros'] }}</div>
                    </div>
                </a>
                <a href="" id="primero" onclick="asig('primero', '{{ $first[0]['area'] }}')">
                    <div class="tarjeta primer-puesto @if($first[0]['color'] =='verde') verde @elseif($first[0]['color'] =='amarillo') amarillo @else rojo @endif">
                        <img src="{{ asset('img/primerlugar.png') }}" class="primer mb-2" alt="User Img">
                        <div class="font-bold text-4xl mt-9">Primer Lugar</div>
                        <div class="font-bold text-2xl mt-4">{{ $first[0]['area'] }}</div>
                        <div class="font-bold text-xl mt-4">Cantidad de Enfermos: {{ $first[0]['cantidad_registros'] }}</div>
                    </div>
                </a>
                <a href="" id="tercero" onclick="asig('tercero', '{{ $first[2]['area'] ?? '' }}')">
                    <div class="tarjeta tercer-puesto @if(isset($first[2]) && $first[2]['color'] =='verde') verde @elseif(isset($first[2]) && $first[2]['color'] =='amarillo') amarillo @else rojo @endif">
                        <img src="{{ asset('img/tercerlugar.png') }}" class="tercer mb-2" alt="User Img">
                        <div class="font-bold text-4xl mt-9">Tercer Lugar</div>
                        <div class="font-bold text-2xl mt-4">{{ $first[2]['area'] ?? '' }}</div>
                        <div class="font-bold text-xl mt-4">Cantidad de Enfermos: {{ $first[2]['cantidad_registros'] ?? '' }}</div>
                    </div>
                </a>

            </div>
            <!-- Anterior-->
            <?php $rating = 4;
            $heigth = 100; ?>
            <center>
                <table class="table center  mb-5" style="width: 70%" data-aos="fade-up">
                    <thead>
                        <tr class="text-center">
                            <th></th>
                            <th>Área</th>
                            <th>Cantidad de Enfermos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zonas as $zona)
                        @if (!in_array($zona['area'], [$first[0]['area'], $first[1]['area'], $first[3]['area'] ?? '']))
                        <tr class="text-center cursor-pointer" data-zona="{{ $zona['area']}}" id="{{ $zona['id']}}">
                            <td style="background-image: @if($zona['color']=='verde') linear-gradient(to bottom, rgba(0, 128, 0, 0), rgb(1, 138, 68)) @elseif($zona['color']=='amarillo') linear-gradient(to bottom, rgba(255,0,0,0), rgb(219, 223, 13)) @else linear-gradient(to bottom, rgba(255,0,0,0), rgb(183, 5, 5)) @endif;">
                                <h5> {{ $rating++ }}°</h5>
                            </td>
                            <td style="background-image: @if($zona['color']=='verde') linear-gradient(to bottom, rgba(0, 128, 0, 0), rgb(1, 138, 68)) @elseif($zona['color']=='amarillo') linear-gradient(to bottom, rgba(255,0,0,0), rgb(219, 223, 13)) @else linear-gradient(to bottom, rgba(255,0,0,0), rgb(183, 5, 5)) @endif;">
                                <h5 class="text-center">{{ $zona['area'] }}</h5>
                            </td>
                            <td style="background-image: @if($zona['color']=='verde') linear-gradient(to bottom, rgba(0, 128, 0, 0), rgb(1, 138, 68)) @elseif($zona['color']=='amarillo') linear-gradient(to bottom, rgba(255,0,0,0), rgb(219, 223, 13)) @else linear-gradient(to bottom, rgba(255,0,0,0), rgb(183, 5, 5)) @endif;">
                                <h5>{{ $zona['cantidad_registros'] }}</h5>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </center>
        </div>
    </div>
</x-app-layout>
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<script>
    var datos = JSON.parse('<?php echo json_encode($zonas); ?>');
    for (var i = 0; i < datos.length; i++) {
        var id = datos[i].id;
        var color = datos[i].color;
        var element = document.getElementById(id);
        if (element) {
            if (element) {
                if (color == 'verde') {
                    estiloVerde(id);
                } else if (color == 'amarillo') {
                    estiloAmarillo(id);
                } else if (color == 'rojo') {
                    estiloRojo(id);
                }
            }
        }
    }
    function estiloVerde(id) {
        $('#' + id + ' td').css('background-image', 'linear-gradient(to bottom, rgba(0, 128, 0, 0), rgb(1, 138, 68))');
    }
    function estiloRojo(id) {
        $('#' + id + ' td').css('background-image', 'linear-gradient(to bottom, rgba(255,0,0,0), rgb(183, 5, 5))');
    }
    function estiloAmarillo(id) {
        $('#' + id + ' td').css('background-image', 'linear-gradient(to bottom, rgba(255,0,0,0), rgb(219, 223, 13))');
    }
</script>
<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
    function filter() {
        var form = document.getElementById('filtroForm');
        form.submit();
        // var tematica = document.getElementById('tematicaFilter').value;
        // const fecha_inicio = document.getElementById('filtro_dia_inicio').value;
        // const fecha_fin = document.getElementById('filtro_dia_fin').value;

        // fetch(SITEURL +'/ranking/filtro',{
        //     method: 'POST',
        //     body: JSON.stringify({
        //         tematica: tematica,
        //         fecha_inicio: fecha_inicio,
        //         fecha_fin: fecha_fin,
        //         "_token": "{{ csrf_token() }}"
        //     }),
        //     headers: {
        //         'Content-Type': 'application/json',
        //         "X-CSRF-Token": csrfToken
        //     },
        // }).then(response => {
        //     if (!response.ok) {
        //         throw new Error('error');
        //     } else
        //         return response.json()
        // }).then(data => {
        //     console.log(data);
            // // Obtén la referencia de la tabla
            // var dataTable = $('#data-table').DataTable();
            //  // Limpiar la tabla antes de agregar nuevos datos
            //  dataTable.clear();
            // if (data.notas.length === 0 ) {
            //     elementoOculto.style.display = "block"; // Mostrar el mensaje
            //     setTimeout(function () {
            //         elementoOculto.style.display = "none"; // Ocultar el mensaje después de 3 segundos
            //     }, 3000);
            // }
            // // Agregar nuevos datos a la tabla
            // data.notas.forEach(nota => {
            //     var urlUsar = `{{route('saluds.edit','id')}}`;
            //         urlUsar = urlUsar.replace('id',nota.id);
            //     var urlUsar2 = `{{route('saluds.destroy','id')}}`;
            //         urlUsar2 = urlUsar2.replace('id',nota.id);
            //     var optionsBtns = `
            //         <!-- Botón Ver -->
            //         <a style="text-decoration: none" href="` + urlUsar + `"
            //             class="rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 mx-auto">Ver
            //         </a>
            //         <!-- Botón Borrar -->
            //         <form action="` + urlUsar2 + `" method="POST"
            //             class="formEliminar rounded-lg bg-red-600 hover:bg-red-700 mx-auto">
            //             @csrf
            //             @method('DELETE')
            //             <button type="submit" class="rounded-lg text-black font-bold py-2 px-4 mx-auto">
            //                 Borrar
            //             </button>
            //         </form>
            //         `;

            //     dataTable.row.add([
            //         nota.id,
            //         nota.rpe,
            //         nota.user.nombre + ' ' + nota.user.paterno + ' ' + nota.user.materno,
            //         nota.fecha,
            //         nota.user.get_area.area_nombre,
            //         nota.user.get_subarea.subarea_nombre,
            //         optionsBtns
            //     ]);
            // });
            // // Dibujar la tabla
            // dataTable.draw();
            // // Centrar elementos en la tabla después de dibujar
            // $(document).ready(function() {
            //     // Aplicar clases de estilo para centrar
            //     $('#data-table').addClass('text-center').addClass('align-middle');
            // });
        // });
    }
</script>
