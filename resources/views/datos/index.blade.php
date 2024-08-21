<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expedientes Medicos de Usuarios') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">
        <x-boton-regresar />
        @php $mostrarDivision = $enfermedadesPermiso; @endphp
        <div class="grid grid-cols-3 md:grid-cols-{{ $mostrarDivision ? 4 : 3}} gap-5 md:gap-8 mx-7">
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                <select id="_area_filtro" name="area_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @can('controlDivisional')
                        <option value="0" style='color: blue;'>Todas</option>
                        @foreach ($areas as $area)
                            <option @if ($area->area_clave == Auth::user()->datos->getArea->area_clave) selected @endif value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                        @endforeach
                    @else
                        <option value="{{ Auth::user()->datos->getArea->area_clave }}">{{ Auth::user()->datos->getArea->area_nombre}}</option>
                    @endcan
                </select>
            </div>
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Subárea:</label>
                <select id="_subarea_filtro" name="subarea_filtro"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                    @foreach ($subareas as $subarea)
                        <option @if($subarea->subarea_clave == Auth::user()->datos->getSubarea->subarea_clave) selected @endif value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Unidad médica:</label>
                <select id="_unidad_medica" name="unidad_medica"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                    @foreach ($unidades_medicas as $unidad_medica)
                        <option value="{{ $unidad_medica->id }}">{{ $unidad_medica->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @if($enfermedadesPermiso)
            <div class="grid grid-cols-1">
                <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Enfermedad:</label>
                <select id="_enfermedad" name="enfermedad"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="0" style='color: blue;'>Todas</option>
                    @foreach ($enfermedades as $enfermedad)
                        <option value="{{ $enfermedad->id }}">{{ $enfermedad->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @endif

        </div>
        <br>
        <div class="grid grid-rows-1 place-items-center mt-3">
            <!-- botón Filtrar -->
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
                <!-- ---------------------------------------------------------------------------------------------->
            <button onClick="filter()" style="text-decoration:none;"
            class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
                <!-- ---------------------------------------------------------------------------------------------->
        </div>
        <br>

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            @if (session()->has('message'))
                <div class="px-2 inline-flex flex-row" id="mssg-status">
                    {{ session()->get('message') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>RPE</th>
                            <th>NOMBRES</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>AREA</th>
                            <th>SUBAREA</th>
                            <th>UNIDAD MÉDICA</th>
                            @if(Auth::user()->hasRole(['admin', 'Doctora']))
                                <th>ENFERMEDADES</th>
                            @endif
                            <th class="none">ACCIONES</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($datosuser as $dato)
                        <tr data-id="{{ $dato->id }}">
                            <td>{{$dato->rpe}}</td>
                            <td>{{$dato->nombre}}</td>
                            <td>{{$dato->paterno}}</td>
                            <td>{{$dato->materno}}</td>
                            @if($dato->getArea!=null)
                                <td>{{$dato->getArea->area_nombre}}</td>
                            @else
                                <td>-</td>
                            @endif
                            @if($dato->getSubarea!=null)
                                <td>{{$dato->getSubarea->subarea_nombre}}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{$dato?->unidad_medica->nombre ?? 'N/A'}}</td>
                            @if(Auth::user()->hasRole(['admin', 'Doctora']))
                                @if ($dato->user?->enfermedadesCronicas && $dato->user?->enfermedadesCronicas->count() > 0)
                                    <td>
                                        @php
                                            $enfermedades = "";
                                            foreach ($dato->user->enfermedadesCronicas as $usuarioEnfermedad) {
                                                $enfermedades .= $usuarioEnfermedad->enfermedadCronica->nombre . ", ";
                                            }
                                            $enfermedades = rtrim($enfermedades, ', ');//quita la coma del último elemento
                                        @endphp
                                        {{$enfermedades}}
                                    </td>
                                @else
                                    <td>N/A</td>
                                @endif
                            @endif
                            <!-- Acciones -->
                            <td @if(!Auth::user()->hasAnyPermission(['antecedente.index', 'notaMedica.index', 'audiometria.index', 'incapacidad.index', 'recepcion.index']))
                                    hidden
                                @endif>
                                <div class="flex justify-center rounded-lg text-lg empty:hidden" role="group">
                                    @can('antecedente.index')
                                    <!-- Consultar antecedentes del usuario -->
                                    <a href="{{ route('personales.indice', $dato->rpe) }}" style="text-decoration: none" class="rounded-lg bg-green-600 hover:bg-green-700 text-black hover:text-white font-bold py-2 px-4 ml-2" >Antecedentes</a>
                                    @endcan
                                    @can('notaMedica.index')
                                    <!-- Consultar notas médicas del usuario -->
                                    <a href="{{ route('saluds.indice', $dato->rpe) }}" style="text-decoration: none" class="rounded-lg bg-blue-500 hover:bg-blue-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Nota Medica</a>
                                    @endcan
                                    @can('audiometria.index')
                                    <!-- Consultar audiometrías  -->
                                    <a href="{{ route('audiometria.historico', ['rpe' => $dato->rpe]) }}" style="text-decoration: none" class="rounded-lg bg-red-400 hover:bg-red-500 text-black hover:text-white font-bold py-2 px-4 ml-2" >Audiometrías</a>
                                    @endcan
                                    <!-- Consultar incapacidades -->
                                    @can('incapacidad.index')
                                    <a href="{{ route('incapacidades.indexByRPE', ['rpe' => $dato->rpe]) }}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Ver incapacidades</a>
                                    @endcan
                                    @can('recepcion.index')
                                    <!-- Consultar prosalud del usuario -->
                                    <a href="{{ route('prosalud.historico', $dato->rpe) }}" style="text-decoration: none" class="rounded-lg bg-orange-500 hover:bg-orange-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Prosalud</a>
                                    @endcan
                                    @canany(['notaMedica.index'])
                                    <!-- Mostrar archivos -->
                                    <a href="{{ route('saluds.archivos', ['rpe' => $dato->rpe]) }}" style="text-decoration: none" class="rounded-lg bg-purple-700 hover:bg-purple-800 text-black hover:text-white font-bold py-2 px-4 ml-2" >Mostrar estudios</a>
                                    @endcanany
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
</x-app-layout>

<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";

    function filter() {
        var f_area = document.getElementById("_area_filtro").value;
        var f_subarea = document.getElementById("_subarea_filtro").value;
        var f_unidad_medica = document.getElementById("_unidad_medica").value;
        var f_enfermedad = '0';
        @if($enfermedadesPermiso)
            f_enfermedad = document.getElementById("_enfermedad").value;
        @endif
        var table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtrarUsuariosExpedientes', {
            method: 'POST',
            body: JSON.stringify({
                division: 'DX',
                area: f_area,
                subarea: f_subarea,
                unidad_medica: f_unidad_medica,
                enfermedad: f_enfermedad,
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
            table.clear();
            //console.log(data.lista)
            var div_Init = "<td class='px-6 py-4 text-center mostrar-usuario'>";
            var div_End = "</td>";
            var rpe = "";
            var nombre = "";
            var paterno = "";
            var materno = "";
            var area = "";
            var subarea = "";
            var unidad_medica = "";
            var enfermedad = "";
            var acciones = "";
            var rpe_string = "";
            //console.log(data);
            for (let i in data.users) {
                rpe_string = data.users[i].rpe;
                rpe = div_Init + data.users[i].rpe + div_End;
                nombre = div_Init + data.users[i].nombre + div_End;
                paterno = div_Init + data.users[i].paterno + div_End;
                materno = div_Init + data.users[i].materno + div_End;
                area = div_Init + data.users[i].get_area.area_nombre + div_End;
                subarea = div_Init + data.users[i].get_subarea.subarea_nombre + div_End;
                if (data.users[i].unidad_medica) {
                    unidad_medica = div_Init + data.users[i].unidad_medica.nombre + div_End;
                }
                else {
                    unidad_medica = div_Init + "N/A" + div_End;
                }
                if (data.users[i].user) {
                    if (data.users[i].user.enfermedades_cronicas && data.users[i].user.enfermedades_cronicas.length > 0) {
                        enfermedad = "";
                        enfermedad += div_Init;
                        for (let j in data.users[i].user.enfermedades_cronicas) {
                            var coma = "";

                            if (j < data.users[i].user.enfermedades_cronicas.length - 1) {//Si no es el último elemento poner coma
                                coma = ", ";
                            }

                            enfermedad += data.users[i].user.enfermedades_cronicas[j].enfermedad_cronica.nombre + coma;
                        }
                        enfermedad += div_End;
                    }
                    else {
                        enfermedad = div_Init + "N/A" + div_End;
                    }
                }
                else {
                    enfermedad = div_Init + "N/A" + div_End;
                }


                var nota_medica_URL = '{{ route('saluds.indice', ':rpe') }}';
                nota_medica_URL = nota_medica_URL.replace(':rpe', data.users[i].rpe);

                var antecedentes_URL = '{{ route('personales.indice', ':rpe') }}';
                antecedentes_URL = antecedentes_URL.replace(':rpe', data.users[i].rpe);

                var rpe_user = data.users[i].rpe;
                var incapacidad_URL = '{{ route('incapacidades.indexByRPE', ':rpeID') }}';
                incapacidad_URL = incapacidad_URL.replace(':rpeID', rpe_user);

                var prosalud_URL = '{{ route('prosalud.historico', ':rpe') }}';
                prosalud_URL = prosalud_URL.replace(':rpe', data.users[i].rpe);

                var archivos_URL = '{{ route('saluds.archivos', ['rpe=:rpe']) }}';
                archivos_URL = archivos_URL.replace(':rpe', data.users[i].rpe);

                var audiometria_URL = '{{ route('audiometria.historico', ':rpe') }}';
                audiometria_URL = audiometria_URL.replace(':rpe', data.users[i].rpe);

                @canany(['antecedente.index', 'notaMedica.index', 'audiometria.index', 'incapacidad.index', 'recepcion.index'])
                acciones = `<div class="flex justify-center rounded-lg text-lg empty:hidden" role="group">`;
                            @can('antecedente.index')
                                acciones += `<a href="${antecedentes_URL}" style="text-decoration: none" class="rounded-lg bg-green-600 hover:bg-green-700 text-black hover:text-white font-bold py-2 px-4 ml-2" >Antecedentes</a>`;
                            @endcan
                            @can('notaMedica.index')
                                acciones += `<a href="${nota_medica_URL}" style="text-decoration: none" class="rounded-lg bg-blue-500 hover:bg-blue-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Nota Medica</a>`;
                            @endcan
                            @can('audiometria.index')
                                acciones += `<a href="${audiometria_URL}" style="text-decoration: none" class="rounded-lg bg-red-400 hover:bg-red-500 text-black hover:text-white font-bold py-2 px-4 ml-2" >Audiometrías</a>`;
                            @endcan
                            @can('incapacidad.index')
                                acciones += `<a href="${incapacidad_URL}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Ver incapacidades</a>`;
                            @endcan
                            @can('recepcion.index')
                                acciones += `<a href="${prosalud_URL}" style="text-decoration: none" class="rounded-lg bg-orange-500 hover:bg-orange-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Prosalud</a>`;
                            @endcan
                            @canany(['notaMedica.index'])
                                acciones += `<a href="${archivos_URL}" style="text-decoration: none" class="rounded-lg bg-purple-700 hover:bg-purple-800 text-black hover:text-white font-bold py-2 px-4 ml-2" >Mostrar estudios</a>`;
                            @endcanany
                acciones += `</div>`;
                @else
                    acciones = `<td style="display:none;"></td>`;
                @endcanany

                var fila = [
                    rpe,
                    nombre,
                    paterno,
                    materno,
                    area,
                    subarea,
                    unidad_medica
                ];
                if(data.enfermedadesPermiso){
                    fila.push(enfermedad, acciones);
                }
                else{
                    fila.push(acciones);
                }
                table.row.add(fila);
            }

            table.draw();

        });
    }
</script>

<script>
    //Actualizar subareas select dependiendo el area
    document.getElementById('_area_filtro').addEventListener('change', (e) => {
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
            var opciones = "<option value='0' style='color: blue;'>Todas</option>";
            for (let i in data.lsubarea) {
                opciones += '<option value="' + data.lsubarea[i].subarea_clave + '">' + data.lsubarea[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("_subarea_filtro").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
