<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <table id="data-table"
                class="table table-striped table-bordered shadow-lg table-fixed w-full  translate-table">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="border px-4 py-2">INDICADOR</th>
                        <th class="border px-4 py-2">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indicadores as $indicador)
                        <tr>
                            <td>
                                <div class="flex">
                                    <div class="font-bold"> {{ strtoupper($indicador->indicador) }} </div> 
                                    <div class="pl-2">{{ $nombreIndicador[$indicador->indicador] }} </div> 
                                </div>
                            </td>
                            <td class="border px-4 py-2 ">
                                <label class="switch">
                                    @if ($indicador->encendido == '1')
                                        <input value='$indicador->encendido'
                                            wire:change="update('{{ $indicador->indicador }}')"
                                            type="checkbox" checked>
                                    @else
                                        <input value='$indicador->encendido'
                                            wire:change="update('{{ $indicador->indicador }}')" 
                                            type="checkbox" uncheked>
                                    @endif
                                    <span class="slider round after:bg-green-300 before:bg-gray-400" ></span>
                                </label>
                            </td>

                    @endforeach
                </tbody>
            </table>
            
        </div>

        @if ($errorMessage)
            <div class="alert alert-danger">
                {{ $errorMessage }}
            </div>
        @endif

        @if ($acceptMessage)
            <div class="alert alert-success">
                {{ $acceptMessage }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
            <div class="grid grid-cols-2 items-center">
                <label
                    class="uppercase md:text-sm text-xs font-semibold">Porcentaje Penalizacion Amarillo:</label>
                <input  name="nombre" 
                    class="py-2 px-3 rounded-lg border-2 border-green-400 mt-1 hover:border-green-600"
                    type="text" required wire:model="valorAmarillo" wire:keydown="mensajes()"/>
            </div> 
            <div class="grid grid-cols-2 items-center">
                <label
                    class="uppercase md:text-sm text-xs font-semibold">Porcentaje Penalizacion Rojo:</label>
                <input  name="nombre"
                    class="py-2 px-3 rounded-lg border-2 border-green-400 mt-1 hover:border-green-600"
                    type="text" required wire:model="valorRojo" wire:keydown="mensajes()"/>
            </div> 
        </div>

        <div class="flex justify-center items-center pt-4">
            <button type="button" wire:click="cambiarPenalizacion()"
                    class="px-4 py-2 text-white bg-green-500 rounded-lg shadow-md hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50">Modificar</button>
        </div>

</div>
