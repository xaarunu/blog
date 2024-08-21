<x-app-layout>
    @section('title', 'DCJ - CFE: ProSalud')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial Prosalud de ' . $usuario->getNombreCompleto()) }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">
        @if (Session::has('success'))
            <div class="alert-success w-80 md:w-1/2 mx-auto py-8 px-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <x-boton-regresar />
        <div class="mt-4 mx-auto sm:px-6 lg:px-8" style="width:95%;">
            @can('prosalud.create')
                <button class="max-h-10 min-h-10 w-56 text-white py-2 px-3 border-2 mb-2 border-blue-500 shadow-xl bg-blue-500 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    onclick="window.location='{{ route('prosalud.create') }}'">Registrar nuevo resultado</button>
            @endcan
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Edad</th>
                            <th>Fecha de toma</th>
                            <th>Glucosa</th>
                            <th>Trigliceridos</th>
                            <th>Colesterol</th>
                            <th>Hemoglobina</th>
                            <th>Leucocitos</th>
                            <th>Plaquetas</th>
                            <th class="none">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $registro)
                            <tr>
                                <td>{{ $registro->area->area_nombre }}</td>
                                <td>{{ $registro->edad }}</td>
                                <td>{{ $registro->fecha_toma }}</td>
                                <td>{{ $registro->glucosa_resultado . ' ' . $registro->glucosa_unidades }}</td>
                                <td>{{ $registro->trigliceridos_resultado . ' ' . $registro->trigliceridos_unidades }}</td>
                                <td>{{ $registro->colesterol_resultado . ' ' . $registro->colesterol_unidades }}</td>
                                <td>{{ $registro->hemoglobina_resultado . ' ' . $registro->hemoglobina_unidades }}</td>
                                <td>{{ $registro->leucocitos_resultado . ' ' . $registro->leucocitos_unidades }}</td>
                                <td>{{ $registro->plaquetas_resultado . ' ' . $registro->plaquetas_unidades }}</td>
                                <td>
                                    @can('prosalud.delete')
                                    <form action="{{ route('prosalud.destroy', $registro->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="py-2 px-4 rounded-md bg-red-600 text-white hover:bg-red-700">Eliminar</button>
                                    </form>
                                    @endcan
                                    <div class="mt-2">
                                        @can('prosalud.edit')
                                            <a class="inline-block py-2 px-3 rounded-md bg-yellow-500 text-white hover:bg-yellow-600" href="{{ route('prosalud.edit', $registro->id) }}">Editar</a>
                                        @endcan
                                        <a class="inline-block py-2 px-3 rounded-md bg-cyan-500 text-white hover:bg-cyan-600" href="{{ route('prosalud.show', $registro->id) }}">Detalles</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex items-center justify-center md:gap-8 gap-4 pb-5">
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
</x-app-layout>
{{-- Ocultar alertas automaticamente --}}
<script>
    $('document').ready(function () {
        $('[role="alert"]').delay(2500).slideUp(300);
    });
</script>
