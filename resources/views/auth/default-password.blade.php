<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <img src="{{ asset('assets/cfe.png') }}" alt="CFE" width="130" height="130" />

        </x-slot>
        <x-jet-validation-errors class="mb-4" />
        <form name="cc" action="{{ route('check.code') }}" method="POST" class="flex flex-col" style="gap: 8px;">
            @csrf
            @if (session('error'))
                <div class="block px-2 py-2 rounded font-medium text-xs bg-red-200 text-red-600">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="block px-2 py-2 rounded font-medium text-xs bg-yellow-200 text-yellow-600">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('info'))
                <div class="block px-2 py-2 rounded font-medium text-xs bg-blue-200 text-blue-600">
                    {{ session('info') }}
                </div>
            @endif
            @if (session('success'))
                <div class="block px-2 py-2 rounded font-medium text-xs bg-green-200 text-green-600">
                    {{ session('success') }}
                </div>
            @endif
            <p class="text-sm text-gray-500 text-left"><strong>Por su seguridad</strong>, debe cambiar la contraseña por
                defecto de su cuenta <strong>ahora mismo</strong>. Mantenga su información protegida en todo momento.
            </p>
            <p class="text-sm text-gray-500 text-left">Se le ha enviado un <strong>código</strong> al siguiente
                <strong>correo electrónico</strong>:
            </p>
            <h2 class="text-center font-bold">{{ $email }}</h2>
            <div class="w-full flex justify-center" style="gap: 8px;">
                <x-input-code data-focus-input-prev="code-0" data-focus-input-next="code-1" id="code-0"
                    name="code_1" />
                <x-input-code data-focus-input-prev="code-0" data-focus-input-next="code-2" id="code-1"
                    name="code_2" />
                <x-input-code data-focus-input-prev="code-1" data-focus-input-next="code-3" id="code-2"
                    name="code_3" />
                <x-input-code data-focus-input-prev="code-2" data-focus-input-next="code-4" id="code-3"
                    name="code_4" />
                <x-input-code data-focus-input-prev="code-3" data-focus-input-next="code-5" id="code-4"
                    name="code_5" />
                <x-input-code data-focus-input-prev="code-4" data-focus-input-next="code-5" id="code-5"
                    name="code_6" />
            </div>
            <p class="text-sm text-gray-500 text-center">Introduzca el código que se le ha enviado por correo.</p>
            <p class="text-sm text-gray-500 text-left">No has recibido ningun código aun?
                <button type="button"
                    class="inline-block	items-center px-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                    id="redeem-code" onclick="ResendCode()" disabled>
                    5:00
                </button>
            </p>
            <input type="submit" style="display:none" name="submitButton">
        </form>
        <div class="flex justify-between mt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase text-white tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    {{ __('Volver') }}
                </button>
            </form>
            <button id="submit"
                class="px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase text-white tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Enviar') }}
            </button>
        </div>

        <script>
            const btn = document.getElementById("redeem-code");
            const regex = /^[a-zA-Z0-9]$/;
            const CtrlKeyCode = [8, 46];
            let ms = {{ $ms }};
            var interval = null;

            document.getElementById("submit").addEventListener('click',() => {
                document.cc.submitButton.click()
            })

            function btnR() {
                btn.innerHTML = 'Reenviar';
                btn.disabled = false;
            }

            function EstablecerIntervalo() {
                btn.disabled = true;
                let sec, min
                interval = setInterval(() => {
                    ms -= 1000
                    sec = Math.floor(ms / 1000)
                    min = Math.floor(sec / 60)
                    sec = sec % 60
                    min = min % 60
                    sec = sec.toString().padStart(2, '0')
                    btn.innerHTML = min + ':' + sec
                    if (ms < 0) {
                        clearInterval(interval);
                        interval = null;
                        btnR();
                    }
                }, 1000);
            }

            if (ms > 0) {
                EstablecerIntervalo();
            } else {
                btnR();
            }

            function handleEvent(e) {
                switch (e.type) {
                    case 'keydown':
                        let DCtrl = (function() {
                            return CtrlKeyCode.includes(e.keyCode)
                        })();
                        if (regex.test(e.key) || DCtrl) {
                            this.value = DCtrl ? '' : e.key;
                            if (e.keyCode === 8) {
                                document.getElementById(this.getAttribute('data-focus-input-prev')).focus()
                            } else {
                                document.getElementById(this.getAttribute('data-focus-input-next')).focus()
                            }
                        }
                        break;
                    case 'paste':
                        const codigo = (e.clipboardData || window.clipboardData).getData("text").substr(0, 6).split('');
                        codigo.forEach((letra, key) => document.getElementById('code-' + key).value = letra);
                        document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
                            element.blur();
                        });
                        document.getElementById('submit').click();
                        break;
                    default:
                        return;
                }
            }

            document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
                element.addEventListener('keydown', handleEvent);
                element.addEventListener('paste', handleEvent);
            });

            function ResendCode() {
                fetch("{{ route('redeem.code') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            timer: data.timer,
                            timerProgressBar: true,
                        });
                        if (interval === null && data.type == 'success') {
                            ms = 300000;
                            EstablecerIntervalo();
                        }
                    })
                    .catch(error => {
                        console.error('Error: ', error);
                    });
            }
        </script>
    </x-jet-authentication-card>
</x-guest-layout>
