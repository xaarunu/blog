<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitar Vacaciones') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-boton-regresar />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('solicitarfuera.update', $solicitudes_vacaciones->id) }}" method="POST"
                    class="formEnviar" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @if ($errors->count() > 0)
                        <div id="ERROR_COPY" style="display:none " class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br />
                            @endforeach
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE
                                Solicitante:</label>
                            <input disabled name="rpe" value='{{ $solicitudes_vacaciones->rpe }}'
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                        </div>


                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Justificación/Observaciones:</label>
                            <input <?php if ($solicitudes_vacaciones->status != 'Pendiente') {
                                print 'disabled';
                            } ?> name="justificacion"
                                value='{{ $solicitudes_vacaciones->justificacion }}'
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha
                                Inicio:</label>
                            <input < <?php if ($solicitudes_vacaciones->status != 'Pendiente') {
                                print 'disabled';
                            } ?> name="fecha_Inicio" id="inicio"
                                value='{{ $solicitudes_vacaciones->fecha_Inicio }}' type="date"
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha
                                Finalización:</label>
                            <input  <?php if ($solicitudes_vacaciones->status != "Pendiente") {
                                print 'disabled';
                            } ?> name="fecha_Fin" id="fin"
                                value='{{ $solicitudes_vacaciones->fecha_Fin }}' type="date"
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Visto Bueno:</label>
                            <select <?php if (!Auth::user()->can('solicitarfuera.visto_bueno') and $solicitudes_vacaciones->status != "Pendiente") {
                                print 'disabled';
                            } ?> name="visto_bueno" value="{{ $solicitudes_vacaciones->visto_bueno }}"
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" required />
                            <option <?php if ($solicitudes_vacaciones->visto_bueno == '1') {
                                print 'selected';
                            } ?>> Si </option>
                            <option <?php if ($solicitudes_vacaciones->visto_bueno == '0') {
                                print 'selected';
                            } ?>> No </option>
                            </select>
                        </div>
                    </div>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('solicitarfuera.index') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>

                        <!-- botón enviar -->
                        <button type="submit" style="background-color: rgb(21 128 61);"
                            class="w-auto rounded-lg shadow-xl font-medium text-white px-4 py-2">Guardar</button>

                    </div>


                </form>

            </div>
        </div>
    </div>
    </div>
</x-app-layout>

<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
<script>
    (function() {
            'use strict'
            //debemos crear la clase formEliminar dentro del form del boton borrar
            //recordar que cada registro a eliminar esta contenido en un form
            var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
            var forms = document.querySelectorAll('.formEnviar')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                                event.preventDefault()
                                event.stopPropagation()
                                Swal.fire({
                                    title: '¿Confirmar el envio?',
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#20c997',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Confirmar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.submit();
                                        Swal.fire('¡Enviado!',
                                            'La solicitud ha sido enviado exitosamente.', 'success');
                                    } else {
                                        //Se oculta el loader para que no tape toda la pantalla por siempre.
                                        loader.style.display = "none";
                                    }
                                }))
                        })
                })()
</script>

<script>
    var has_errors = {{ $errors->count() > 0 ? 'true' : 'false' }};
    if (has_errors) {
        Swal.fire({
            title: 'Advertencia',
            icon: 'info',
            html: jQuery("#ERROR_COPY").html(),
            showCloseButton: true,
        });
    }
</script>
