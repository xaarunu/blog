<style>
    /* since nested groupes are not supported we have to use
    regular css for the nested dropdowns
    */
    .MENU li>ul {
        transform: translatex(100%) scale(0);
        z-index: 50;
    }

    .MENU li:hover>ul {
        transform: translatex(101%) scale(1);
        z-index: 50;
    }

    .MENU li>button svg {
        transform: rotate(-90deg);
        z-index: 50;
    }

    .MENU li:hover>button svg {
        transform: rotate(-270deg);
        z-index: 50;
    }

    .MENU .group:hover .group-hover\:scale-100 {
        transform: scale(1);
        z-index: 50;
    }

    .MENU .group:hover .group-hover\:-rotate-180 {
        transform: rotate(180deg);
        z-index: 50;
    }

    .MENU .scale-0 {
        transform: scale(0);
        z-index: 50;
    }

    .MENU .min-w-32 {
        min-width: 8rem;
        z-index: 50;
    }

    .MENU a:link {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }

    .MENU a:visited {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }

    .MENU a:hover {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }

    .MENU a:active {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }
    .prueba{
        position: fixed;
        z-index: 50;
        width: 100%;
    }
</style>
<nav x-data="{ open: false }" class="prueba bg-white border-b h-20 border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('salud.inicio') }}">
                        {{-- <x-jet-application-mark class="block h-9 w-auto" /> --}}
                        <img src="{{ asset('assets/cfe.png') }}" alt="CFE" width="115" height="115" />

                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="MENU">
                    <div class="hidden space-x-8 sm:flex sm:items-center sm:ml-1 justify-between h-16">
                        <!-- Control interno -->
                        @if (Auth::user()->hasAnyRole(['admin', 'RecursosHumanos', 'JefeRecursosHumanos']))
                            <div class="group inline-block" align="left" width="30">
                                <button
                                    class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                    <span class="pr-1 font-semibold flex-1">Control interno</span>
                                    <span>
                                        <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                transition duration-150 ease-in-out"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </span>
                                </button>
                                <ul
                                    class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                            transition duration-150 ease-in-out origin-top min-w-32">
                                    <!-- Usuarios -->
                                    @can('users.index')
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <button
                                                class="w-full text-left flex items-center outline-none focus:outline-none">
                                                <span class="pr-1 flex-1">Usuarios</span>
                                                <span class="mr-auto">
                                                    <svg class="fill-current h-4 w-4
                                        transition duration-150 ease-in-out"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                    </svg>
                                                </span>
                                            </button>

                                            <ul
                                                class="bg-white border rounded-sm absolute top-0 right-0
                                        transition duration-150 ease-in-out origin-top-left
                                        min-w-32
                                        ">
                                                <a href="{{ route('users.inicio') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Inicio</li>
                                                </a>
                                                <a href="{{ route('users.index') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Gestión</li>
                                                </a>
                                                @can('roles.index')
                                                    <a href="{{ route('roles.index') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Roles</li>
                                                    </a>
                                                @endcan
                                                @can('users.create')
                                                    <a href="{{ route('users.create') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                    </a>
                                                @endcan
                                                @can('users.autorizar')
                                                    <a href="{{ route('users.pendientes.index') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Pendientes</li>
                                                    </a>
                                                @endcan
                                                @can('users.usuariosBaja')
                                                    <a href="{{ route('users.usuariosBaja') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Baja</li>
                                                    </a>
                                                @endcan
                                                <a href="{{ route('users.centros') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Centros de Trabajo</li>
                                                </a>
                                                @canany(['recepcion.index', 'recepcion.create'])
                                                    <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                                        <button class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                                            <span class="pr-1 flex-1" style="min-width:6rem;">Entregas de recepción</span>
                                                            <span class="mr-auto">
                                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                                </svg>
                                                            </span>
                                                        </button>
                                                        <ul class="bg-white border rounded-sm absolute top-0 right-0
                                                            transition duration-150 ease-in-out origin-top-left
                                                            min-w-32">
                                                            @can('recepcion.index')
                                                                <li class="px-3 py-1 hover:bg-gray-100">
                                                                    <a href="{{ route('recepcion.index') }}">Mostrar</a>
                                                                </li>
                                                            @endcan
                                                            @can('recepcion.create')
                                                                <li class="px-3 py-1 hover:bg-gray-100">
                                                                    <a href="{{ route('recepcion.create') }}">Crear</a>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </li>
                                                @endcanany
                                            </ul>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        @endif
                        <!-- Mi Salud -->
                        @if (Auth::user()->hasAnyRole(['admin', 'Doctora', 'RecursosHumanos', 'JefeRecursosHumanos']))
                            {{-- Expedientes de usuarios --}}
                            <div class="group inline-block items-center" align="left" width="30">
                                <button
                                    class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                    <span class="pr-1 font-semibold flex-1">Expedientes</span>
                                    <span>
                                        <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </span>
                                </button>
                                <ul
                                    class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                transition duration-150 ease-in-out origin-top min-w-32">
                                    <a href="{{ route('datos.index') }}">
                                        <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                    </a>
                                    {{-- Antecedentes --}}

                                    @canany(['antecedente.index', 'antecedente.create'])
                                    <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                        <button
                                            class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                            <span class="pr-1 flex-1">Antecedentes</span>
                                            <span class="mr-auto">
                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm absolute top-0 right-0
                                                    transition duration-150 ease-in-out origin-top-left
                                                    min-w-32">
                                            @can('antecedente.create')
                                            <a href="{{ route('personales.create', 0) }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                            </a>
                                            @endcan
                                            @can('antecedente.index')
                                            <a href="{{ route('personales.showAllAntecedentes') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                            </a>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcanany
                                    {{-- Notas medicas --}}
                                        @canany(['notaMedica.index', 'notaMedica.create'])
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <button
                                                class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                                <span class="pr-1 flex-1">Notas Médicas</span>
                                                <span class="mr-auto">
                                                    <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <ul
                                                class="bg-white border rounded-sm absolute top-0 right-0
                                                transition duration-150 ease-in-out origin-top-left
                                                min-w-32">
                                                @can('notaMedica.create')
                                                <a href="{{ route('saluds.create', ['rpe' => 0]) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                </a>
                                                @endcan
                                                @can('notaMedica.index')
                                                <a href="{{ route('saluds.showAllNotasMedicas') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                                </a>
                                                @endcan
                                            </ul>
                                        </li>
                                        @endcanany
                                    {{-- Audiometrías --}}
                                        @canany(['audiometria.index', 'audiometria.create'])
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <button
                                                class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                                <span class="pr-1 flex-1">Audiometrías</span>
                                                <span class="mr-auto">
                                                    <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <ul
                                                class="bg-white border rounded-sm absolute top-0 right-0
                                                        transition duration-150 ease-in-out origin-top-left
                                                        min-w-32">
                                                @can('audiometria.create')
                                                <a href="{{ route('audiometrias.create') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                </a>
                                                @endcan
                                                @can('audiometria.index')
                                                <a href="{{ route('audiometrias.index') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                                </a>
                                                @endcan
                                            </ul>
                                        </li>
                                        @endcanany
                                    {{-- incapacidades --}}
                                    @canany(['incapacidad.index', 'incapacidad.create'])
                                    <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                        <button
                                            class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                            <span class="pr-1 flex-1">Incapacidades</span>
                                            <span class="mr-auto">
                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm absolute top-0 right-0
                                                    transition duration-150 ease-in-out origin-top-left
                                                    min-w-32">
                                            @can('incapacidad.create')
                                                @if(Auth::user()->hasAnyRole(['RecursosHumanos', 'JefeRecursosHumanos' ]))
                                                <a href="{{ route('datos.index', ['rpe' => 0]) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                </a>

                                            @else
                                                <a href="{{ route('incapacidades.create', ['rpe' => 0]) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                </a>
                                            @endif
                                            @endcan
                                            @can('incapacidad.index')
                                            <a href="{{ route('incapacidades.index') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                            </a>
                                            <a href="{{ route('estadisticas.incapacidades.padecimientos') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Gráfica</li>
                                            </a>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcanany
                                    {{-- PROSALUD --}}
                                    @canany(['prosalud.index', 'prosalud.create'])
                                    <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                        <button
                                            class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                            <span class="pr-1 flex-1">Prosalud</span>
                                            <span class="mr-auto">
                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm absolute top-0 right-0
                                                    transition duration-150 ease-in-out origin-top-left
                                                    min-w-32">
                                            <a href="{{ route('prosalud.index') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                            </a>
                                            @can('prosalud.create')
                                                <a href="{{ route('prosalud.create') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                </a>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcanany
                                    {{-- ANTIDOPING --}}
                                    @canany(['antidoping.index', 'antidoping.create'])
                                    <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                        <button
                                            class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                            <span class="pr-1 flex-1">Antidoping</span>
                                            <span class="mr-auto">
                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm absolute top-0 right-0
                                                    transition duration-150 ease-in-out origin-top-left
                                                    min-w-32">

                                            <a href="{{ route('prosalud.indexAntidoping') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Mostrar</li>
                                            </a>
                                        </ul>
                                    </li>
                                    @endcanany
                                </ul>
                            </div>

                            {{-- UMF --}}
                            @if (Auth::user()->hasRole('JefeRecursosHumanos') || Auth::user()->hasRole('admin'))
                                @canany(['notaMedica.index', 'notaMedica.create', 'antecedente.index', 'antecedente.create'])
                                    <div class="group inline-block" align="left" width="30">
                                        <button
                                            class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                            <span class="pr-1 font-semibold flex-1">UMF</span>
                                            <span>
                                                <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                            transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                        transition duration-150 ease-in-out origin-top min-w-32">
                                            @canany(['notaMedica.create', 'antecedente.create'])
                                            <a href="{{ route('unidad_medica.created') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Crear UMF</li>
                                            </a>
                                            @endcanany
                                            @canany(['notaMedica.index', 'antecedente.index'])
                                            <a href="{{ route('unidad_medica.index') }}">
                                                <li class="px-3 py-1 hover:bg-gray-100">Mostrar UMF</li>
                                            </a>
                                            @endcanany
                                        </ul>
                                    </div>
                                @endcanany
                            @endif
                        @if(Auth::user()->hasAnyRole(['admin', 'Doctora']))
                            {{-- Personal con sintomas Reportes Rij --}}
                            {{-- <div class="group inline-block" align="left" width="30">
                                <button
                                    class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                    <span class="pr-1 font-semibold flex-1">Reportes RIJ</span>
                                    <span>
                                        <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                    transition duration-150 ease-in-out"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </span>
                                </button>
                                <ul
                                    class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                transition duration-150 ease-in-out origin-top min-w-32">
                                    <a href="{{ route('personal_sintomas.index') }}">
                                        <li class="px-3 py-1 hover:bg-gray-100">Mostrar personal</li>
                                    </a>
                                    <a href="{{ route('personal_sintomas_atendido.show') }}">
                                        <li class="px-3 py-1 hover:bg-gray-100">Mostrar personal atendido</li>
                                    </a>
                                    <a href="{{ route('personal_sintomas_incapacitado.show') }}">
                                        <li class="px-3 py-1 hover:bg-gray-100">Personal incapacitado</li>
                                    </a>
                                </ul>
                            </div> --}}
                            {{-- estadística --}}
                            @endif
                            <div class="group inline-block" align="left" width="30">
                                <button
                                    class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32  ">
                                    <span class="pr-1 font-semibold flex-1 ">Estadística</span>
                                    <span>
                                        <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                        transition duration-150 ease-in-out"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </span>
                                </button>
                                <ul
                                    class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                    transition duration-150 ease-in-out origin-top min-w-32">
                                    {{-- @canany(['notaMedica.stats'])
                                        <a href="{{ route('reportesSalud.show') }}">
                                            <li class="px-3 py-1 hover:bg-gray-100">Notas Médicas</li>
                                        </a>
                                    @endcanany --}}
                                    {{-- Se va a cambiar por otro Módulo --}}
                                    @canany(['incapacidad.stats'])
                                        <a href="{{ route('padecimientos.show', ['rpe' => 0]) }}">
                                            <li class="px-3 py-1 hover:bg-gray-100">Padecimientos de personal</li>
                                        </a>
                                    @endcanany
                                    {{-- Incapacidades Stats --}}
                                    @canany(['incapacidad.stats'])
                                    <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                        <button
                                            class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                            <span class="pr-1 flex-1">Análisis de Incapacidades</span>
                                            <span class="mr-auto">
                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm absolute top-0 right-0
                                    transition duration-150 ease-in-out origin-top-left
                                    min-w-32
                                    ">
                                    <a href="{{ route('estadisticas.incapacidades.incapacidades') }}">
                                        <li class="px-3 py-1 hover:bg-gray-100">General</li>
                                    </a>
                                    <a href="{{ route('estadisticas.incapacidades.padecimientos') }}">
                                        <li class="px-3 py-1 hover:bg-gray-100">Padecimientos</li>
                                    </a>
                                        </ul>
                                    </li>
                                    @endcanany
                                    {{-- Audiometrías Stats --}}
                                    @canany(['audiometria.stats'])
                                        <a href="{{ route('audiometria.estadisticas') }}">
                                            <li class="px-3 py-1 hover:bg-gray-100">Resultados audiometrias</li>
                                        </a>
                                    @endcanany
                                    {{-- Pro Salud --}}
                                    @canany(['prosalud.stats'])
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <button
                                                class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                                <span class="pr-1 flex-1">ProSalud</span>
                                                <span class="mr-auto">
                                                    <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <ul
                                                class="bg-white border rounded-sm absolute top-0 right-0
                                        transition duration-150 ease-in-out origin-top-left
                                        min-w-32
                                        ">
                                                <a href="{{ route('prosalud.estadistica.general') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">General</li>
                                                </a>
                                                {{-- <a href="{{ route('prosalud.estadistica.zona', ['zona' => 'Oficionas Divisionales']) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Zonas</li>
                                                </a> --}}
                                                <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato' => 'Glucosa']) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Padecimientos</li>
                                                </a>
                                                <a href="{{ route('prosalud.estadistica.examenes') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Examenes</li>
                                                </a>
                                                <a href="{{ route('estadisticas.prosalud.historial') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Histórico</li>
                                                </a>
                                            </ul>
                                        </li>
                                    @endcanany
                                    {{-- Expedientes --}}
                                    @canany(['expedientes.stats'])
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <button
                                                class="w-full text-left flex items-center outline-none focus:outline-none text-black">
                                                <span class="pr-1 flex-1">Expedientes</span>
                                                <span class="mr-auto">
                                                    <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <ul
                                                class="bg-white border rounded-sm absolute top-0 right-0
                                                transition duration-150 ease-in-out origin-top-left
                                                min-w-32
                                            ">
                                                <a href="{{ route('personales.estadistica.general') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">General</li>
                                                </a>
                                                {{-- <a href="{{ route('prosalud.estadistica.zona', ['zona' => 'Oficionas Divisionales']) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Zonas</li>
                                                </a>
                                                <a href="{{ route('prosalud.estadistica.estadisticaDato', ['dato' => 'Glucosa']) }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Enfermedades</li>
                                                </a>
                                                <a href="{{ route('prosalud.estadistica.examenes') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Examenes</li>
                                                </a> --}}
                                            </ul>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>

                            {{-- Prestaciones --}}
                            @canany(['prestacion.index', 'prestacion.create'])
                            <div class="group inline-block">
                                <button
                                    class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32  ">
                                    <span class="pr-1 font-semibold flex-1 ">Prestaciones</span>
                                    <span>
                                        <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                        transition duration-150 ease-in-out"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </span>
                                </button>
                                <ul
                                    class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                    transition duration-150 ease-in-out origin-top min-w-32">
                                    <li class="px-3 py-1 hover:bg-gray-100">
                                        <button
                                            class="w-full text-left flex items-center outline-none focus:outline-none">
                                            <span class="pr-1 flex-1">Lentes</span>
                                            <span class="mr-auto">
                                                <svg class="fill-current h-4 w-4 transition duration-150 ease-in-out"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </span>
                                        </button>
                                        <ul
                                            class="bg-white border rounded-sm absolute top-0 right-0
                                            transition duration-150 ease-in-out origin-top-left min-w-32">
                                            <li class="px-3 py-1 hover:bg-gray-100">
                                                <a href="{{ route('lentes.index') }}">Mostrar</a>
                                            </li>
                                            @can('prestacion.create')
                                            <li class="px-3 py-1 hover:bg-gray-100">
                                                <a href="{{ route('lentes.create') }}">Crear</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            @endcanany
                        @endif
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                        {{ Auth::user()->currentTeam->rpe }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>

                                <x-slot name="content">
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <!-- Team Settings -->
                                        <x-jet-dropdown-link
                                            href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-jet-dropdown-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-jet-dropdown-link>
                                        @endcan

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-jet-switchable-team :team="$team" />
                                        @endforeach
                                    </div>
                                </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="inline-flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-150 transition align-middle">
                                    <img class="h-8 w-8 mr-2 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->rpe }}" />
                                    {{ Auth::user()->rpe }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->rpe }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administracion') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('users.datosPersonales') }}">
                                {{ __('Datos personales') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Configuracion') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Cerrar') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
<div class="h-20"></div>
