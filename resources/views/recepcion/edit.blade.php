<x-app-layout>
    @section('title', 'DCJ - CFE: Entrega de recepción')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Entrega de Recepción') }}</h2>
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
                    <span>{{ implode('', $errors->all(':message')) }}</span>
                </div>
            </div>
        @endif  

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-entrega-recepcion-form :registro="$registro" accion="edit"/>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    "use strict";
    (function () {
        // Al cargar la página llenar las listas de roles disponibles para ambos usuarios
        document.addEventListener('DOMContentLoaded', function () {
            try {
                document.querySelectorAll('input.rpe').
                    forEach(async (input) => {
                        const type = input.name.split('_')[1];
                        const { roles } = await modulo.getInformacionUser(input);
                        modulo.ListasRoles[type] = roles;
                    });
            } catch (error) {
                console.error(error);
            }
        });
    })();
</script>
