<x-app-layout>
    @section('title', 'DCJ - CFE: Prestación de lentes')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar prestación de lentes') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <x-boton-regresar />

        {{-- Flash msg --}}
        @if ($errors->any())
            <div class="alert-error border rounded-lg w-80 md:w-1/2 mx-auto py-8 px-4 my-4" role="alert">
                @if($errors->any())
                    <h5 class="text-lg">Datos erroneos, verifica la información ingresada</h5>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li class="list-item pl-4">* {{ $error }}</li>
                        @endforeach
                    </ol>
                @endif
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg w-10/12 p-7 mx-auto max-w-7xl">
            <x-lentes-form :user="$usuario" />
            <div class="flex items-center justify-center md:gap-8 gap-4 mt-5 md:mt-8">
                <a href="{{ route('lentes.index') }}"
                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                <button type="submit" form="formEnviar"
                    class='w-auto bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    .alert-error { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
</style>