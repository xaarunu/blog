<x-app-layout>
    @section('title', 'DCJ - CFE')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            {{ ('Estudios de: ') . $usuario->nombre . " " . $usuario->paterno . " " . $usuario->materno }}

        </h2>
    </x-slot>

    <div class="py-10">
        <x-boton-regresar />
        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>Nota Medica</th>
                            <th>Fecha</th>
                            <th>Archivos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($idSalud as $sal)
                            @foreach ( $sal->archivos as $archi)
                                <tr>
                                    {{-- {{dd($sal)}} --}}
                                    <td align="center"><a href="{{ route('saluds.edit', $sal->id)}}" style="text-decoration: none" class="text-black" style="text-decoration: none"> {{ $sal->id }} </a></td>
                                    <td align="center">{{ \Carbon\Carbon::parse($sal->fecha)->format('d/m/Y') }}</td>
                                    <td align="center"><a href="{{ $archi->archivo }}" target="_blank" style="text-decoration: none" class="text-black"> {{ $archi->nombre }} </a></td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>

                </table>

                <div class="flex items-center justify-center  md:gap-8 gap-4 pb-5">
                    <!-- botón volver -->
                    <a type="button" href="{{ route('datos.index') }}" style="text-decoration:none"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
    @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
@endsection
</x-app-layout>
