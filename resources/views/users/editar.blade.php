<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-boton-regresar />
        <x-user-data-form accion="edit"
            :divisiones="$divisiones"
            :areas="$areas"
            :subareas="$subareas"
            :roles="$roles"
            :user="$user" :datos="$datos"
        />
    </div>
</x-app-layout>

<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
