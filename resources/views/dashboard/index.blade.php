<x-app2>
    @section('title', 'DCJ - CFE')

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="padding-bottom: 0">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>Inicio <span>Pon aquí el nombre de tu sistema</span></h1>
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
                    {{-- @if (!Auth::user()->hasRole('usuario')) --}}
                        <!-- EXPEDIENTES DE USUARIOS -->
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            {{-- <a href="{{ route('#') }}" class="card-link"> --}}
                            <a href="#" class="card-link">
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


                        {{-- <!-- ======= Contenedor para centrar el aviso ======= -->
                        @if (!Auth::user()->hasAnyRole(['usuario','admin','RecursosHumanos','JefeRecursosHumanos','Doctora']))
                            <div class="container text-center my-5">
                                <div class="alert alert-info">
                                    <strong>¡Aviso!</strong> Actualmente cuenta con permisos de usuario incorrectos para el
                                    uso de este sistema.
                                </div>
                            </div>
                        @endif --}}
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
