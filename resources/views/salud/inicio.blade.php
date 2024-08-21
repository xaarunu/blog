<x-app2>
    @section('title', 'DCJ - CFE')

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="padding-bottom: 0">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>Inicio <span>CFE-Bienestar</span></h1>
            <h2>Aquí podrás ver los registros de los expedientes de los usuarios y darlos de alta</h2>
            <div class="d-flex">
                <a href="#featured-services" class="btn-get-started scrollto"><b>Sistemas</b></a>
                <!--<a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Video de presentación </span></a>-->
            </div>
            <x-cfeui::header/>
        </div>
    </section><!-- End Hero -->
    <main id="main">
        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services" href="#services">
            <div class="container" data-aos="fade-up">

                @php
                    $delay = 0;
                    $espacio = 100;
                    $max = 400;
                @endphp
                <div class="row">
                    {{-- <div class="col-lg-12 d-flex align-items-stretch mb-4">
                        <a href="{{ asset('storage/ejemploacuerdo.pdf') }}" target="_blank" class="btn btn-success">Descargar Acuerdo de Confidencialidad</a>
                    </div> --}}
                    @if (!Auth::user()->hasRole('usuario'))
                        <!-- EXPEDIENTES DE USUARIOS -->
                        @canany(['antecedente.index', 'notaMedica.index'])
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('datos.index') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-pulse"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M16.97 4.757a.999.999 0 0 0-1.918-.073l-3.186 9.554l-2.952-6.644a1.002 1.002 0 0 0-1.843.034L5.323 12H2v2h3.323c.823 0 1.552-.494 1.856-1.257l.869-2.172l3.037 6.835c.162.363.521.594.915.594l.048-.001a.998.998 0 0 0 .9-.683l2.914-8.742l.979 3.911A1.995 1.995 0 0 0 18.781 14H22v-2h-3.22l-1.81-7.243z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Expedientes de usuarios</h4>
                                    <p class="description">Obtener los registros de los expedientes médicos de los
                                        usuarios.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <!-- CREAR ANTECEDENTES -->
                        @can('antecedente.create')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('personales.create', 0) }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M229.66,58.34l-32-32a8,8,0,0,0-11.32,0l-96,96A8,8,0,0,0,88,128v32a8,8,0,0,0,8,8h32a8,8,0,0,0,5.66-2.34l96-96A8,8,0,0,0,229.66,58.34ZM124.69,152H104V131.31l64-64L188.69,88ZM200,76.69,179.31,56,192,43.31,212.69,64ZM224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear antecedente.</h4>
                                    <p class="description">crear un atecdente nuevo para algun usuario.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <!-- MOSTRAR ANTECEDENTES -->

                        @can('antecedente.index')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('personales.showAllAntecedentes') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H156.69A15.86,15.86,0,0,0,168,219.31L219.31,168A15.86,15.86,0,0,0,224,156.69V48A16,16,0,0,0,208,32ZM48,48H208V152H160a8,8,0,0,0-8,8v48H48ZM196.69,168,168,196.69V168Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Mostrar antecedentes</h4>
                                    <p class="description">Aquí podras ver todos los antecedentes realizados.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <!-- CREAR NOTAS MÉDICAS -->
                        @can('notaMedica.create')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('saluds.create') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M88,96a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H96A8,8,0,0,1,88,96Zm8,40h64a8,8,0,0,0,0-16H96a8,8,0,0,0,0,16Zm32,16H96a8,8,0,0,0,0,16h32a8,8,0,0,0,0-16ZM224,48V156.69A15.86,15.86,0,0,1,219.31,168L168,219.31A15.86,15.86,0,0,1,156.69,224H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32H208A16,16,0,0,1,224,48ZM48,208H152V160a8,8,0,0,1,8-8h48V48H48Zm120-40v28.7L196.69,168Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear nota médica</h4>
                                    <p class="description">crear una nota médica nueva.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <!-- MOSTRAR NOTAS MÉDICAS -->
                        @can('notaMedica.index')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('saluds.showAllNotasMedicas') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M213.66,66.34l-40-40A8,8,0,0,0,168,24H88A16,16,0,0,0,72,40V56H56A16,16,0,0,0,40,72V216a16,16,0,0,0,16,16H168a16,16,0,0,0,16-16V200h16a16,16,0,0,0,16-16V72A8,8,0,0,0,213.66,66.34ZM168,216H56V72h76.69L168,107.31v84.53c0,.06,0,.11,0,.16s0,.1,0,.16V216Zm32-32H184V104a8,8,0,0,0-2.34-5.66l-40-40A8,8,0,0,0,136,56H88V40h76.69L200,75.31Zm-56-32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h48A8,8,0,0,1,144,152Zm0,32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h48A8,8,0,0,1,144,184Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Mostrar notas médicas</h4>
                                    <p class="description">Aquí podras ver todas las notas médicas realizadas.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        @endif
                        {{--
                        <!-- GRAFICA REPORTES DE NOTAS MÉDICAS -->
                        @can('notaMedica.stats')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('reportesSalud.show') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0v94.37L90.73,98a8,8,0,0,1,10.07-.38l58.81,44.11L218.73,90a8,8,0,1,1,10.54,12l-64,56a8,8,0,0,1-10.07.38L96.39,114.29,40,163.63V200H224A8,8,0,0,1,232,208Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Grafica de notas médicas</h4>
                                    <p class="description">Mostrar cantidad de notas médicas generadas a lo largo del
                                        año.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        --}}
                        <!-- CREAR INCAPACIDADES -->
                        @can('incapacidad.create')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            @if(Auth::user()->hasAnyRole(['RecursosHumanos','JefeRecursosHumanos']))
                                <a href="{{ route('datos.index') }}" class="card-link">
                            @else
                                <a href="{{ route('incapacidades.create') }}" class="card-link">
                            @endif
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear incapacidad</h4>
                                    <p class="description">crear una incapacidad nueva para algun usuario.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <!-- MOSTRAR INCAPACIDADES -->
                        @can('incapacidad.index')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('incapacidades.index') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Mostrar incapacidades de usuarios</h4>
                                    <p class="description">Mostrar todas las incapacidades de los usuarios.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan
                        <!-- RANKING INCAPACIDADES -->
                        @can('incapacidad.stats')
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                                <a href="{{ route('ranking') }}" class="card-link">
                                    <div class="icon-box service-box" data-aos="fade-up"
                                        data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                                <path
                                                    d="M232,64H208V56a16,16,0,0,0-16-16H64A16,16,0,0,0,48,56v8H24A16,16,0,0,0,8,80V96a40,40,0,0,0,40,40h3.65A80.13,80.13,0,0,0,120,191.61V216H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16H136V191.58c31.94-3.23,58.44-25.64,68.08-55.58H208a40,40,0,0,0,40-40V80A16,16,0,0,0,232,64ZM48,120A24,24,0,0,1,24,96V80H48v32q0,4,.39,8Zm144-8.9c0,35.52-28.49,64.64-63.51,64.9H128a64,64,0,0,1-64-64V56H192ZM232,96a24,24,0,0,1-24,24h-.5a81.81,81.81,0,0,0,.5-8.9V80h24Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="title">Análisis de incapacidades</h4>
                                        <p class="description">Mostrar que area tiene menor número de incapacidades.
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endcan
                        <!-- Mostrar formualrio para registrar nuevas audiometrias  -->
                        @can('audiometria.create')
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                                <a href="{{ route('audiometrias.create') }}" class="card-link">
                                    <div class="icon-box service-box" data-aos="fade-up"
                                        data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.00 24.00" id="Layer_1" data-name="Layer 1" fill="currentColor" class="iconos">
                                                <g>
                                                    <defs>
                                                        <style>
                                                            .cls-1 {
                                                                fill: none;
                                                                stroke-miterlimit: 10;
                                                                stroke-width: 1.6;
                                                            }
                                                        </style>
                                                    </defs>
                                                    <line class="cls-1" stroke="currentColor" x1="12" y1="11.05" x2="12" y2="18.68"></line>
                                                    <line class="cls-1" stroke="currentColor" x1="15.82" y1="12.95" x2="15.82" y2="16.77"></line>
                                                    <line class="cls-1" stroke="currentColor" x1="8.18" y1="12.95" x2="8.18" y2="16.77"></line>
                                                    <polygon class="cls-1" stroke="currentColor" points="20.59 6.27 20.59 22.5 3.41 22.5 3.41 1.5 15.82 1.5 20.59 6.27"></polygon>
                                                    <polygon class="cls-1" stroke="currentColor" points="20.59 6.27 20.59 7.23 14.86 7.23 14.86 1.5 15.82 1.5 20.59 6.27"></polygon>
                                                </g>
                                            </svg>
                                        </div>
                                        <h4 class="title">Registrar audiometría</h4>
                                        <p class="description">Crear un nuevo registro de una audiometría realizada.
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endcan
                        <!-- Mostrar registros de audiometrias  -->
                        @if(Auth::user()->hasAnyRole(['admin', 'Doctora', ]))
                        @can('audiometria.index')
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                                <a href="{{ route('audiometrias.index') }}" class="card-link">
                                    <div class="icon-box service-box" data-aos="fade-up"
                                        data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="iconos" viewBox="0 0 512 512"
                                                transform="matrix(-1, 0, 0, 1, 0, 0)">
                                                <g>
                                                    <path
                                                        d="M460.292,450.719l-0.905-0.095c0.08,0.072-0.667,2.741-3.163,5.959c-3.671,4.902-10.694,10.964-19.68,15.398 c-9.002,4.489-19.879,7.484-31.63,7.476c-13.706-0.04-28.698-3.893-44.707-14.968c-15.334-10.702-23.28-19.276-28.578-27.904 c-3.973-6.523-6.65-13.499-9.209-22.5c-3.838-13.436-7.134-31.161-14.293-54.321c-7.174-23.184-18.274-51.707-37.835-87.666 c-15.604-28.562-29-71.164-28.912-111.494c0-16.915,2.288-33.409,7.389-48.481c5.116-15.095,12.959-28.777,24.368-40.631 c26.982-27.872,58.095-38.867,87.683-38.947c21.412-0.016,41.958,5.982,58.618,16.041c16.701,10.05,29.334,24.026,35.786,39.574 l30.032-12.521c-9.582-22.962-27.236-41.792-49.022-54.933C414.409,7.572,388.261,0.016,360.819,0 c-37.843-0.08-78.292,14.762-111.105,48.91c-15.024,15.556-25.337,33.719-31.773,52.788c-6.451,19.084-9.096,39.082-9.104,58.905 c0.095,47.329,14.849,93.721,32.868,127.035c16.518,30.406,26.37,54.52,32.996,74.462c4.965,14.969,8.128,27.602,10.9,39.082 c4.188,17.114,7.397,32.194,15.414,47.377c3.996,7.532,9.185,14.841,15.85,21.873c6.674,7.039,14.778,13.824,24.757,20.768 c21.094,14.723,43.19,20.848,63.291,20.8c23.819-0.032,44.572-8.183,59.842-19.124c7.659-5.514,14.016-11.734,18.799-18.568 c4.72-6.857,8.263-14.388,8.374-23.589H460.292z">
                                                    </path>
                                                    <path
                                                        d="M392.036,257.033c-11.394,2.121-21.778,8.613-28.928,18.345c-7.206,9.726-11.187,22.477-11.17,37.001 c0,7.778,1.119,16.097,3.463,24.876c4.044,15.136,10.988,27.49,20.236,36.309c9.192,8.811,20.944,13.952,33.139,13.92 c12.696,0.032,25.25-5.529,35.403-15.477c6.722-6.547,10.853-14.889,13.3-23.787c2.462-8.931,3.337-18.608,3.353-28.889 c-0.016-17.154-2.526-36.094-5.8-55.695c-3.29-19.585-7.381-39.805-10.734-59.08c-3.679-20.856-9.486-43.134-21.222-61.455 c-5.88-9.129-13.396-17.313-23.009-23.2c-9.582-5.895-21.198-9.272-34.117-9.24c-0.985,0-1.97,0.015-2.956,0.055 c-15.755,0.5-29.159,6.372-38.232,15.938c-9.121,9.526-13.824,21.841-15.588,34.521c-0.93,6.682,3.726,12.847,10.408,13.769 c6.674,0.93,12.839-3.726,13.761-10.4v-0.008c1.256-9.041,4.418-16.208,9.026-20.975c4.648-4.728,10.837-7.961,21.547-8.454 l2.034-0.039c8.851,0.032,15.533,2.113,21.373,5.657c8.692,5.276,15.771,14.595,21.245,26.79 c5.474,12.125,9.184,26.776,11.687,41.22c3.146,18.067,6.769,36.42,9.813,54.011c-8.256-4.442-17.495-6.777-26.894-6.769 C399.465,255.976,395.737,256.326,392.036,257.033z M436.115,313.109c0.024,0.191,0.088,0.366,0.12,0.557 c0.064,1.882,0.19,3.869,0.19,5.665c0.016,8.819-0.818,16.478-2.462,22.405c-1.653,5.975-3.996,10.043-6.802,12.776 c-6.531,6.285-12.744,8.541-18.385,8.564c-5.426-0.023-10.901-2.097-16.311-7.19c-5.355-5.085-10.392-13.316-13.483-24.924 c-1.852-6.944-2.638-13.157-2.638-18.584c0.015-10.17,2.701-17.504,6.379-22.492c3.726-4.974,8.43-7.818,13.857-8.875 c2.216-0.421,4.425-0.627,6.594-0.627c8.096,0.015,15.596,2.812,21.436,8.096C430.426,293.795,434.852,301.645,436.115,313.109z">
                                                    </path>
                                                    <path
                                                        d="M148.621,156.83c-3.385-5.825-10.853-7.802-16.677-4.402c-5.832,3.392-7.794,10.853-4.41,16.685 c2.686,4.616,5.212,9.296,7.468,14.071c25.202,53.216,22.08,112.631-3.234,161.27c-3.106,5.99-0.786,13.348,5.188,16.462 c5.991,3.107,13.348,0.795,16.463-5.188c28.682-55.076,32.233-122.601,3.638-183C154.437,167.19,151.576,161.906,148.621,156.83z">
                                                    </path>
                                                    <path
                                                        d="M96.096,183.358c-3.393-5.824-10.862-7.802-16.693-4.418c-5.824,3.401-7.794,10.87-4.418,16.693 c1.915,3.281,3.687,6.547,5.252,9.86c17.67,37.326,15.469,78.935-2.272,113.051c-3.114,5.975-0.786,13.348,5.188,16.462 c5.975,3.115,13.348,0.787,16.463-5.187c21.118-40.537,23.74-90.273,2.686-134.766C100.354,190.945,98.249,187.068,96.096,183.358z ">
                                                    </path>
                                                    <path
                                                        d="M46.844,215.901c-1.32-2.781-2.718-5.236-4.005-7.469c-3.384-5.832-10.853-7.818-16.685-4.441 c-5.832,3.384-7.818,10.861-4.433,16.685v0.008c1.184,2.042,2.232,3.917,3.058,5.657c10.146,21.444,8.844,45.192-1.342,64.793 c-3.123,5.982-0.795,13.34,5.18,16.454c5.975,3.122,13.34,0.803,16.446-5.172l0.016-0.008 c11.854-22.724,14.682-50.007,6.134-75.645C49.99,223.107,48.528,219.477,46.844,215.901z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <h4 class="title">Mostrar audiometrías</h4>
                                        <p class="description">Mostrar los resultados de todas las audiometrias realizadas.
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endcan
                        @endif
                        <!-- GRAFICA REPORTES DE AUDIOMETRIAS -->
                        @can('audiometria.stats')
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                                <a href="{{ route('audiometria.estadisticas') }}" class="card-link">
                                    <div class="icon-box service-box" data-aos="fade-up"
                                        data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="none" class="iconos" viewBox="0 0 24.0 24.00">
                                                <g stroke-width="0"></g>
                                                <g stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g>
                                                    <path d="M19.9497 17.9497L15 13H22C22 14.933 21.2165 16.683 19.9497 17.9497Z" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M20 10C20 6.13401 16.866 3 13 3V10H20Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path
                                                        d="M2 12C2 16.4183 5.58172 20 10 20C12.2091 20 14.2091 19.1046 15.6569 17.6569L10 12V4C5.58172 4 2 7.58172 2 12Z"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <h4 class="title">Gráficas de audiometrías</h4>
                                        <p class="description">Mostrar gráficas con los resultados de las audiometrías realizadas.
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endcan
                        @if (Auth::user()->hasRole('JefeRecursosHumanos') || Auth::user()->hasRole('admin'))
                            <!-- Crear Unidad medica -->
                            @canany(['antecedente.create', 'notaMedica.create'])
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                                <a href="{{ route('unidad_medica.created') }}" class="card-link">
                                    <div class="icon-box service-box" data-aos="fade-up"
                                        data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                                <path
                                                    d="M216,64H176V56a24,24,0,0,0-24-24H104A24,24,0,0,0,80,56v8H40A16,16,0,0,0,24,80V208a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64ZM96,56a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96ZM216,208H40V80H216V208Zm-56-64a8,8,0,0,1-8,8H136v16a8,8,0,0,1-16,0V152H104a8,8,0,0,1,0-16h16V120a8,8,0,0,1,16,0v16h16A8,8,0,0,1,160,144Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="title">Crear unidad medica</h4>
                                        <p class="description">Crear una nueva unidad medica.
                                        </p>
                                    </div>
                                </a>
                            </div>
                            @endcanany
                            <!-- Mostrar Unidades medicas -->
                            @canany(['antecedente.index', 'notaMedica.index'])
                            <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                                <a href="{{ route('unidad_medica.index') }}" class="card-link">
                                    <div class="icon-box service-box" data-aos="fade-up"
                                        data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                                <path
                                                    d="M240,208H224V96a16,16,0,0,0-16-16H144V32a16,16,0,0,0-24.88-13.32L39.12,72A16,16,0,0,0,32,85.34V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM208,96V208H144V96ZM48,85.34,128,32V208H48ZM112,112v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm-32,0v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm0,56v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Zm32,0v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="title">Mostrar unidades medicas</h4>
                                        <p class="description">Mostrar todas las unidades medicas.
                                        </p>
                                    </div>
                                </a>
                            </div>
                            @endcanany
                        @endif

                        {{-- @can('incapacidad.index')
                        <!-- Mostrar Personal con sintomas -->
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('personal_sintomas.index') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm53.66-53.66a8,8,0,0,1-11.32,11.32L160,163.31l-10.34,10.35a8,8,0,0,1-11.32,0L128,163.31l-10.34,10.35a8,8,0,0,1-11.32,0L96,163.31,85.66,173.66a8,8,0,0,1-11.32-11.32l16-16a8,8,0,0,1,11.32,0L112,156.69l10.34-10.35a8,8,0,0,1,11.32,0L144,156.69l10.34-10.35a8,8,0,0,1,11.32,0ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm72,0a12,12,0,1,1,12,12A12,12,0,0,1,152,108Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Personal con sintomas</h4>
                                    <p class="description">Mostrar a los usuarios reportados con sintomas y darle
                                        seguimiento a su caso.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <!-- Mostrar Personal con sintomas atendidos -->
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('personal_sintomas_atendido.show') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M230.33,141.06a24.34,24.34,0,0,0-18.61-4.77C230.5,117.33,240,98.48,240,80c0-26.47-21.29-48-47.46-48A47.58,47.58,0,0,0,156,48.75,47.58,47.58,0,0,0,119.46,32C93.29,32,72,53.53,72,80c0,11,3.24,21.69,10.06,33a31.87,31.87,0,0,0-14.75,8.4L44.69,144H16A16,16,0,0,0,0,160v40a16,16,0,0,0,16,16H120a7.93,7.93,0,0,0,1.94-.24l64-16a6.94,6.94,0,0,0,1.19-.4L226,182.82l.44-.2a24.6,24.6,0,0,0,3.93-41.56ZM119.46,48A31.15,31.15,0,0,1,148.6,67a8,8,0,0,0,14.8,0,31.15,31.15,0,0,1,29.14-19C209.59,48,224,62.65,224,80c0,19.51-15.79,41.58-45.66,63.9l-11.09,2.55A28,28,0,0,0,140,112H100.68C92.05,100.36,88,90.12,88,80,88,62.65,102.41,48,119.46,48ZM16,160H40v40H16Zm203.43,8.21-38,16.18L119,200H56V155.31l22.63-22.62A15.86,15.86,0,0,1,89.94,128H140a12,12,0,0,1,0,24H112a8,8,0,0,0,0,16h32a8.32,8.32,0,0,0,1.79-.2l67-15.41.31-.08a8.6,8.6,0,0,1,6.3,15.9Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Personal con sintomas atendidos</h4>
                                    <p class="description">Mostrar a los usuarios reportados con sintomas que ya han
                                        sido atendidos.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <!-- Mostrar Personal con sintomas incapacitado -->
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('personal_sintomas_incapacitado.show') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="iconos" viewBox="0 0 256 256">
                                            <path
                                                d="M176,104a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,104Zm-8,24H88a8,8,0,0,0,0,16h80a8,8,0,0,0,0-16Zm88-24v24a32,32,0,0,1-32,32h-5.13c-6.54,14.44-19.26,27.12-37.7,37.36-21,11.68-43.52,17-49.92,18.3a15.7,15.7,0,0,1-6.5,0c-6.4-1.34-28.9-6.62-49.92-18.3C56.39,187.12,43.67,174.44,37.13,160H32A32,32,0,0,1,0,128V104A32,32,0,0,1,32,72h.85a16,16,0,0,1,9.68-10l80-29.09a16.06,16.06,0,0,1,10.94,0l80,29.09a16,16,0,0,1,9.68,10H224A32,32,0,0,1,256,104ZM32.53,144a59.94,59.94,0,0,1-.53-7.85V88a16,16,0,0,0-16,16v24a16,16,0,0,0,16,16ZM208,136.15V77.09L128,48,48,77.09v59.06c0,45.76,71.84,62.13,80,63.85C136.16,198.28,208,181.91,208,136.15ZM240,104a16,16,0,0,0-16-16v48.15a59.94,59.94,0,0,1-.53,7.85H224a16,16,0,0,0,16-16Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="title">Personal incapacitado</h4>
                                    <p class="description">Mostrar a los usuarios incapacitados.
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endcan --}}

                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('prosalud.estadistica.general') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.00 24.00" fill="none" stroke="currentColor" class="iconos">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Grafica de ProSalud</h4>
                                    <p class="description">Mostrar estadisticas de ProSalud.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('prosalud.estadistica.examenes') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.00 24.00" fill="none" stroke="currentColor" class="iconos">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Grafica Examenes de ProSalud</h4>
                                    <p class="description">Mostrar estadisticas de cantidad de personas con examenes en ProSalud.
                                    </p>
                                </div>
                            </a>
                        </div>

                        <!-- ======= Contenedor para centrar el aviso ======= -->
                        @if (!Auth::user()->hasAnyRole(['usuario','admin','RecursosHumanos','JefeRecursosHumanos','Doctora']))
                            <div class="container text-center my-5">
                                <div class="alert alert-info">
                                    <strong>¡Aviso!</strong> Actualmente cuenta con permisos de usuario incorrectos para el
                                    uso de este sistema.
                                </div>
                            </div>
                        @endif
                    {{-- @endif --}}
                </div>

            </div>
            </div>
        </section><!-- End Featured Services Section -->

        <x-cfeui::footer/>
        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
        </body>
</x-app2>
