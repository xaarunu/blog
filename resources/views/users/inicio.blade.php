<x-app2>
    @section('title', 'DCJ - CFE')

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>Inicio <span>Usuarios</span></h1>
            <h2>Aquí podrás dar de alta o baja usuarios del sistema, administrar los usuarios y sus respectivos roles
            </h2>
            <div class="d-flex">
                <a href="#featured-services" class="btn-get-started scrollto"><b>Sistemas</b></a>
                <!--<a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Video de presentación </span></a>-->
            </div>
            <x-cfeui::header/>
        </div>
    </section><!-- End Hero -->
    <main id="main">

        <x-boton-regresar />
        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services" href="#services">
            <div class="container" data-aos="fade-up">

                @php
                    $delay = 0;
                    $espacio = 100;
                    $max = 400;
                @endphp
                <div class="row">
                    <!-- Gestión -->
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                        <a href="{{ route('users.index') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-group"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M16.604 11.048a5.67 5.67 0 0 0 .751-3.44c-.179-1.784-1.175-3.361-2.803-4.44l-1.105 1.666c1.119.742 1.8 1.799 1.918 2.974a3.693 3.693 0 0 1-1.072 2.986l-1.192 1.192l1.618.475C18.951 13.701 19 17.957 19 18h2c0-1.789-.956-5.285-4.396-6.952z" />
                                        <path fill="currentColor"
                                            d="M9.5 12c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2zm1.5 7H8c-3.309 0-6 2.691-6 6v1h2v-1c0-2.206 1.794-4 4-4h3c2.206 0 4 1.794 4 4v1h2v-1c0-3.309-2.691-6-6-6z" />
                                    </svg>
                                </div>
                                <h4 class="title">Gestión</h4>
                                <p class="description">En este enlace podrás administrar los usuarios que se encuentran
                                    dentro del sistema.</p>
                            </div>
                        </a>
                    </div>
                    <!-- Roles -->
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                        <a href="{{ route('roles.index') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-user-circle"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12 2A10.13 10.13 0 0 0 2 12a10 10 0 0 0 4 7.92V20h.1a9.7 9.7 0 0 0 11.8 0h.1v-.08A10 10 0 0 0 22 12A10.13 10.13 0 0 0 12 2zM8.07 18.93A3 3 0 0 1 11 16.57h2a3 3 0 0 1 2.93 2.36a7.75 7.75 0 0 1-7.86 0zm9.54-1.29A5 5 0 0 0 13 14.57h-2a5 5 0 0 0-4.61 3.07A8 8 0 0 1 4 12a8.1 8.1 0 0 1 8-8a8.1 8.1 0 0 1 8 8a8 8 0 0 1-2.39 5.64z" />
                                        <path fill="currentColor"
                                            d="M12 6a3.91 3.91 0 0 0-4 4a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2a1.91 1.91 0 0 1 2-2a1.91 1.91 0 0 1 2 2a1.91 1.91 0 0 1-2 2z" />
                                    </svg>
                                </div>
                                <h4 class="title">Roles</h4>
                                <p class="description">Administración de roles para los usuarios.</p>
                            </div>
                        </a>
                    </div>
                    <!--Crear-->
                    @can('users.create')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('users.create') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-user-plus"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM4 8a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4a3.91 3.91 0 0 0-4 4zm6 0a1.91 1.91 0 0 1-2 2a1.91 1.91 0 0 1-2-2a1.91 1.91 0 0 1 2-2a1.91 1.91 0 0 1 2 2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear</h4>
                                    <p class="description">Aquí podrás crear nuevos usuarios para el sistema.</p>
                                </div>
                            </a>
                        </div>
                    @endcan
                    <!-- Usuarios dados de baja -->
                    @can('users.usuariosBaja')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('users.usuariosBaja') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-user-minus"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M14 11h8v2h-8zM8 4a3.91 3.91 0 0 0-4 4a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2a1.91 1.91 0 0 1 2-2a1.91 1.91 0 0 1 2 2a1.91 1.91 0 0 1-2 2zm-4 8a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Baja</h4>
                                    <p class="description">Aquí podrás dar de baja usuarios.</p>
                                </div>
                            </a>
                        </div>
                    @endcan


                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                        <a href="{{ route('users.centros') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-group"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M16.604 11.048a5.67 5.67 0 0 0 .751-3.44c-.179-1.784-1.175-3.361-2.803-4.44l-1.105 1.666c1.119.742 1.8 1.799 1.918 2.974a3.693 3.693 0 0 1-1.072 2.986l-1.192 1.192l1.618.475C18.951 13.701 19 17.957 19 18h2c0-1.789-.956-5.285-4.396-6.952z" />
                                        <path fill="currentColor"
                                            d="M9.5 12c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2zm1.5 7H8c-3.309 0-6 2.691-6 6v1h2v-1c0-2.206 1.794-4 4-4h3c2.206 0 4 1.794 4 4v1h2v-1c0-3.309-2.691-6-6-6z" />
                                    </svg>
                                </div>
                                <h4 class="title"> Centros de Trabajo</h4>
                                <p class="description">Muestra las subáreas de cada área de una división.</p>
                            </div>
                        </a>
                    </div>
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
