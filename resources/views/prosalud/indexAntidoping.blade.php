<x-app-layout>
    @section('title', 'DCJ - CFE: ProSalud')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ANTIDOPING') }}
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
        <div class="mx-auto sm:px-6 lg:px-8" style="width:95%;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>RPE</th>
                            <th>Nombre</th>
                            <th>Resultado</th>
                            <th>Zona</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antidoping as $doping)
                            <tr>
                                <td>{{ $doping->rpe }}</td>
                                <td>{{ $doping->nombre }}</td>
                                <td>{{ $doping->resultado }}</td>
                                <td>{{ $doping->zona }}</td>
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
