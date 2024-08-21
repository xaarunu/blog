<form id="formEnviar" action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method(($accion == "create") ? "POST" : "PUT")
    
    <div class="grid grid-cols-1 gap-5 @if(!$modal) md:grid-cols-2 md:gap-8 @endif">
        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">RPE:</label>
            <input id="rpe" type="text" maxlength="5" name="rpe" required value="{{ old('rpe') ?? $user?->rpe }}"
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent @if($user) bg-gray-200" readonly @else " @endif>
        </div>
        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre:</label>
            <input id="solicitante" type="text" name="nombre" readonly value="{{ old('nombre') ?? $user?->getNombreCompleto() }}"
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent bg-gray-200">
        </div>
        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fecha de asignación:</label>
            <input type="date" name="fecha_asignacion" max="{{ Date('Y-m-d') }}" required value="{{ old('fecha_asignacion') ?? $prestacion?->fecha_asignacion ?? Date('Y-m-d') }}"
                @if($accion == 'show') readonly @endif
                class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent">
        </div>
        <div class="grid grid-cols-1">
            <label for="archivo" class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Archivo
                relacionado:</label>
            @if($accion == "show")
                @php $archivo = $prestacion->archivo; @endphp
                <a target="_blank" @if($archivo) href="{{ asset($archivo->getFilePath()) }}" @endif
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent" >
                    {{ $archivo?->nombre_archivo ?? 'Sin archivo relacionado' }}
                </a>
            @else
                <input name="archivo" type="file" accept=".pdf"
                    class="py-2 px-3 rounded-lg border-2 border-green-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent">
            @endif
        </div>
    </div>
</form>
<script>
    // Busqueda por RPE (obtener nombre)
    const SITEURL = "{{ url('/') }}";
    document.getElementById('rpe').addEventListener("input", (e) => {
        if (e.srcElement.value.length >= 5) {
            fetch(`${SITEURL}/incapacidades/crearregistro/buscar?rpe=${e.srcElement.value}`, { method: 'get' })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("solicitante").value = data.datosuser.nombreCompleto;
                })
                .catch(error => {
                    console.error('Error:', 'No se encontró ese rpe');
                    // RPE no encontrado, establece los valores en nulo
                    document.getElementById("solicitante").value = "";
                    document.getElementById("rpe").value = "";
                });
        } else {
            document.getElementById("solicitante").value = "";
        }
    });
</script>