<x-app-layout>
    @section('title', 'DCJ - CFE')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            {{ __('Expedientes') }}

        </h2>
    </x-slot>

    <div class="py-12">
        <x-boton-regresar />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="grid grid-cols-4 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">RPE:</label>
                        <input name="rpe" value="{{$miSalud->rpe}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha Nacimiento:</label>
                        <input name="fecha_nacimiento" value="{{$miSalud->fecha_nacimiento}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Sexo:</label>
                        <input name="sexo" value="{{$miSalud->sexo}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div style="grid-column: 4; grid-row-start:1; grid-row-end:3" class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Foto Cara:</label>
                        <input name="foto_cara" value="{{$miSalud->foto_cara}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="image" required/>
                    </div>
                    <div style="grid-column-start:1; grid-column-end:4" class="grid grid-cols-5 gap-5 md:gap-8">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Peso:</label>
                            <input name="peso" value="{{$miSalud->peso}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Altura:</label>
                            <input name="altura" value="{{$miSalud->altura}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">imc:</label>
                            <input name="imc" value="{{$miSalud->imc}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Estomago:</label>
                            <input name="estomago" value="{{$miSalud->estomago}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Espalda:</label>
                            <input name="espalda" value="{{$miSalud->espalda}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Alergias:</label>
                        <input name="alergias" value="{{$miSalud->alergias}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Padecimientos:</label>
                        <input name="padecimientos" value="{{$miSalud->padecimientos}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Discapacidad:</label>
                        <input name="discapacidad" value="{{$miSalud->discapacidad}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div style="grid-column-start:1; grid-column-end:4" class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Observaciones:</label>
                        <input name="observaciones" value="{{$miSalud->observaciones}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" required/>
                    </div>
                    <div style="grid-column:4; grid-row-start:3; grid-row-end:5" class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Foto Cuerpo:</label>
                        <input name="foto_cuerpo" value="{{$miSalud->foto_cuerpo}}" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="image" required/>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-fixed w-full">
                    <caption>Expedientes Capturados</caption>
                    <thead>
                        <tr class="bg-gray-800 text-white">

                            <th class="border px-4 py-2">RPE</th>
                            <th class="border px-4 py-2">Fecha de nacimiento</th>
                            <th class="border px-4 py-2">Sexo</th>
                            <th class="border px-4 py-2">Cuerpo</th>
                            <th class="border px-4 py-2">Cara</th>
                            <th class="border px-4 py-2">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="{{ $miSalud->id }}">

                            <td style="display: none;">{{$miSalud->id}}</td>

                            <td>{{$miSalud->rpe}}</td>
                            <td>{{$miSalud->fecha_nacimiento}}</td>
                            <td>{{$miSalud->sexo}}</td>
                            <td>{{$miSalud->foto_cuerpo}}</td>
                            <td>{{$miSalud->foto_cara}}</td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <!-- botón editar -->
                                    <a href="{{ route('saluds.index', $miSalud->id) }}" class="rounded bg-yellow-400 hover:bg-yellow-400 text-white font-bold py-2 px-4 mx-2">VER EXPEDIENTE</a>

                                    {{-- <!-- botón borrar -->
                                    <form action="{{ route('saluds.destroy', $miSalud->id) }}" method="POST" class="formEliminar bg-red-400 hover:bg-red-600">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded text-black font-bold py-2 px-4">Borrar</button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-app-layout>
