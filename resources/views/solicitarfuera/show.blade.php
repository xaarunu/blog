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

                <form action="{{ route('solicitarfuera.approve', $solicitudes_vacaciones) }}" method="POST"
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
                                type="text" />
                        </div>


                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Justificación/Observaciones:</label>
                            <input name="justificacion" value='{{ $solicitudes_vacaciones->justificacion }}'
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" disabled />
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha
                                Inicio:</label>
                            <input < name="fecha_Inicio" id="inicio"
                                value='{{ $solicitudes_vacaciones->fecha_Inicio }}' type="date"
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" disabled />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Status:</label>
                            <input name="status id="status" value='{{ $solicitudes_vacaciones->status }}'
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" disabled />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha
                                Finalización:</label>
                            <input name="fecha_Fin" id="fin" value='{{ $solicitudes_vacaciones->fecha_Fin }}'
                                type="date" style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                type="text" disabled />
                        </div>
                        @if (Auth::user()->can('solicitarfuera.visto_bueno') or $solicitudes_vacaciones->status == 'Pendiente')
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Visto
                                    Bueno:</label>
                                <select name="visto_bueno" id="visto_bueno"
                                    value="{{ $solicitudes_vacaciones->visto_bueno }}"
                                    style="border-color: rgb(21 128 61);"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required />
                                <option <?php if ($solicitudes_vacaciones->visto_bueno == '1') {
                                    print 'selected';
                                } ?>> Aprobar </option>
                                <option <?php if ($solicitudes_vacaciones->visto_bueno == '0') {
                                    print 'selected';
                                } ?>> Rechazar </option>
                                </select>
                            </div>
                        @elseif(Auth::user()->can('solicitarfuera.rh') or $solicitudes_vacaciones->status == 'Visto Bueno')
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Autorización
                                    RH:</label>
                                <select name="rh" id="rh" value="{{ $solicitudes_vacaciones->rh }}"
                                    style="border-color: rgb(21 128 61);"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required />
                                <option <?php if ($solicitudes_vacaciones->rh == '1') {
                                    print 'selected';
                                } ?>> Aprobar </option>
                                <option <?php if ($solicitudes_vacaciones->rh == '0') {
                                    print 'selected';
                                } ?>> Rechazar </option>
                                </select>
                            </div>
                        @elseif (Auth::user()->can('solicitarfuera.autorizar') or $solicitudes_vacaciones->status == 'Pre-aprobado')
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Autorización:</label>
                                <select name="autorizacion" id="autorizacion"
                                    value="{{ $solicitudes_vacaciones->autorizacion }}"
                                    style="border-color: rgb(21 128 61);"
                                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent"
                                    type="text" required />
                                <option <?php if ($solicitudes_vacaciones->autorizacion == '1') {
                                    print 'selected';
                                } ?>> Aprobar </option>
                                <option <?php if ($solicitudes_vacaciones->autorizacion == '0') {
                                    print 'selected';
                                } ?>> Rechazar </option>
                                </select>
                            </div>
                        @endif
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase mgd:text-sm text-xs text-gray-500 text-light font-semibold grid ">Comentarios:</label>
                            <input id="comentario" name="comentario" style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent grid-cols-1""
                                type="text" value="{{ $solicitudes_vacaciones->comentario }}" required />
                        </div>
                    </div>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5  '>
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
