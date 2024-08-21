<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-boton-regresar />
        <x-user-data-form :areas="$areas" :subareas="$subareas" :divisiones="$divisiones" :roles="$roles"/>
    </div>
</x-app-layout>

<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
