<x-app-layout>
    @section('title', 'DCJ - CFE: Entrega de recepción')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Registrar Entrega de Recepción') }}</h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    @endsection

    <div class="py-12">
        <x-boton-regresar />

        @if($errors->any())
            <div class="d-flex justify-center my-3">
                <div class="w-3/5 alert alert-danger rounded my-0" role="alert">
                    <h5>Ocurrio un error</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-item">* {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-entrega-recepcion-form :userDefault="$usuarioAusente" />
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // Ejecutar evento "input" al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('[name="rpe_ausente"]').dispatchEvent(new Event('input'));
        document.querySelector('[name="rpe_receptor"]').dispatchEvent(new Event('input'));
    });
</script>
