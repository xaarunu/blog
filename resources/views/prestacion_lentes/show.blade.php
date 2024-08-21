<x-app-layout>
    @section('title', 'DCJ - CFE: Prestación de lentes')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestación de lentes') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <x-boton-regresar />
        
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg w-10/12 p-7 mx-auto max-w-7xl">
            <x-lentes-form accion="show" :user="$usuario" :prestacion="$registro" />
            <div class="flex items-center justify-center md:gap-8 gap-4 mt-5 md:mt-8">
                <a href="{{ route('lentes.index') }}"
                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Volver</a>
            </div>
        </div>
    </div>
</x-app-layout>