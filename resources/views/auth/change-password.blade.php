<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <img src="{{ asset('assets/cfe.png') }}" alt="CFE" width="130" height="130"/>

        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{route('change.password.default')}}" id="form1">
            @csrf
            @method('put')
            @if (session('warning'))
                <div class="block px-2 py-2 rounded font-medium text-xs bg-yellow-200 text-yellow-600">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('error'))
                <div class="block px-2 py-2 rounded font-medium text-xs bg-red-200 text-red-600">
                    {{ session('error') }}
                </div>
            @endif
            <h2 class="font-bold text-center">Actualizar Contraseña</h2>
            <div class="mt-2">
                <x-jet-label for="password" value="{{ __('Nueva Contraseña') }}" class="text-md"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,50}$" required/>
            </div>
            <div class="mt-2">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" class="text-md"/>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,50}$" name="password_confirmation" required/>
            </div>
            <div class="my-2 text-xs text-gray-400">
                <span>La contraseña debe contener por lo menos:</span>
                <ol style="list-style: circle;" class="pl-10">
                    <li>Una longitud entre 8 y 50</li>
                    <li>Una letra mayuscula</li>
                    <li>Una letra minusculas</li>
                    <li>Un digito</li>
                    <li>Un simbolo</li>
                </ol>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Guardar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
    <script>
        document.getElementById("form1").addEventListener('submit',function (e) {
            let pw1 = document.getElementById("password").value;
            let pw2 = document.getElementById("password_confirmation").value;
            let pl = document.getElementById("preloader");
            if (pw1 != pw2) {
                e.preventDefault();
                if(pl){pl.remove();}
                Swal.fire({
                    title: "Las contraseñas no coinciden",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                });
            }else if(!pl){
                let div = document.createElement("div");
                div.id = "preloader";
                div.style.display = "block";
                document.body.insertBefore(div, document.body.firstChild);
            }
        });
    </script>
</x-guest-layout>
