<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mostrar usuario pendiente') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-boton-regresar />

        <div class="px-10 pb-3 leading-normal max-w-7xl mx-auto">
            <div class="text-right">
                <button id="btnHabilitar" class="bg-gray-500 hover:bg-green-600 rounded-lg shadow-xl font-medium text-white px-10 py-2">Habilitar edición</button>
            </div>
        </div>

        <x-user-data-form accion="pendiente.show"
            :divisiones="$divisiones"
            :areas="$areas"
            :subareas="$subareas"
            :roles="$roles"
            :user="$user" :datos="$datos">

            <a href="{{ route('users.rechazar', $id) }}"
                class='w-auto bg-red-500 hover:bg-red-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Rechazar</a>
            <a id="btnAutorizar" href="{{ route('users.autorizar', $id) }}"
                class='w-auto bg-green-600 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Autorizar</a>
            <button id="btnActualizar" type="submit" form="formEnviar" hidden disabled
                class='w-auto bg-green-600 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Actualizar y Autorizar</button>
        </x-user-data-form>
    </div>
</x-app-layout>
<style>
    select:disabled, input:disabled {
    background-color: #e5e7eb;
    color: black;
    cursor: not-allowed;
    opacity: 1;
    }
</style>

<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

<script>
    "use strict";

    (function () {
        const habilitarEdicionBtn = document.getElementById('btnHabilitar');
        let edicionHabilitada = false;
        const camposEditables = ["rpe", "email", "nombre", "paterno", "materno", "ingreso",
                            "contrato", "puesto", "division", "area", "subarea", "roles[]"];

        habilitarEdicionBtn.addEventListener('click', () => {
            !edicionHabilitada ? habilitarEdicion() : DeshabilitarEdicion();

            // Cambiar variable de control
            edicionHabilitada = !edicionHabilitada;
        });

        function habilitarEdicion() {
            for(const campo of camposEditables) {
                const input = document.querySelector(`[name="${campo}"]`);

                // Si se recibe "roles[]"
                if(campo == "roles[]") {
                    document.querySelectorAll('[name="roles[]"]').
                        forEach(inputRol => {
                            inputRol.removeAttribute('disabled');
                        });
                }

                input.removeAttribute('disabled');
            }

            // Actualización de botones
            document.getElementById('btnHabilitar').classList.remove('bg-gray-500');
            document.getElementById('btnHabilitar').classList.add('bg-green-500');
            document.getElementById('btnHabilitar').textContent = "Edición Habilitada";

            document.getElementById('btnActualizar').removeAttribute('hidden');
            document.getElementById('btnActualizar').removeAttribute('disabled');

            document.getElementById('btnAutorizar').setAttribute('hidden', true);
            document.getElementById('btnAutorizar').setAttribute('disabled', true);
        }

        function DeshabilitarEdicion() {
            for(const campo of camposEditables) {
                const input = document.querySelector(`[name="${campo}"]`);

                // Si se recibe "roles[]"
                if(campo == "roles[]") {
                    document.querySelectorAll('[name="roles[]"]').
                        forEach(inputRol => {
                            inputRol.setAttribute('disabled');
                        });
                }

                input.setAttribute('disabled');
            }

            // Actualización de botones
            document.getElementById('btnHabilitar').classList.add('bg-gray-500');
            document.getElementById('btnHabilitar').classList.remove('bg-green-500');
            document.getElementById('btnHabilitar').textContent = "Habilitar edición";

            document.getElementById('btnActualizar').setAttribute('hidden');
            document.getElementById('btnActualizar').setAttribute('disabled');

            document.getElementById('btnAutorizar').removeAttribute('hidden', true);
            document.getElementById('btnAutorizar').removeAttribute('disabled', true);
        }
    })();
</script>
