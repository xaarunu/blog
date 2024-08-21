<x-app-layout>
    @section('title', 'DCJ - CFE: Entrega de recepción')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Mostrar Entrega de Recepción') }}</h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    @endsection

    <div class="py-12">
        <x-boton-regresar />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-entrega-recepcion-form :registro="$entrega" accion="show" />
            </div>
        </div>
    </div>
</x-app-layout>