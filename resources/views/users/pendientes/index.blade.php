<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('USUARIOS PENDIENTES') }}
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
        @if (Session::has('message'))
            <div class="alert-success w-80 md:w-1/2 mx-auto py-8 px-4" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="mt-4 mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>RPE</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Puesto</th>
                            <th>Centro de trabajo</th>
                            <th>Roles</th>
                            <th class="none">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-center mostrar-usuario">{{ $user['estatus'] == 1 ? 'Nuevo' : 'Modificación' }}</td>
                                <td class="px-6 py-4 text-center mostrar-usuario">{{ $user['rpe'] }}</td>
                                <td class="px-6 py-4 text-center mostrar-usuario">{{ $user['nombre'] }}</td>
                                <td class="px-6 py-4 text-center mostrar-usuario">{{ $user['correo'] }}</td>
                                <td class="px-6 py-4 text-center mostrar-usuario">{{ $user['puesto'] }}</td>
                                <td class="px-6 py-4 text-center mostrar-usuario">{{ $user['centro'] }}</td>
                                <td class="px-6 py-4 text-center mostrar-usuario">
                                    @foreach ($user['roles'] as $rol)
                                        <span>
                                            {{$rol->name}}
                                        </span>
                                        <br>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        <a href="{{ route('users.pendientes.show', $user['id']) }}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2">Ver</a>
                                        <a href="{{ route('users.autorizar', $user['id']) }}" style="text-decoration: none" class="rounded-lg bg-green-500 hover:bg-green-600 text-black hover:text-white font-semibold py-2 px-4 ml-2">Confirmar</a>
                                        <a href="{{ route('users.rechazar', $user['id']) }}" style="text-decoration: none" class="rounded-lg bg-red-400 hover:bg-red-500 text-black hover:text-white font-semibold py-2 px-4 ml-2">Rechazar</a>
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
