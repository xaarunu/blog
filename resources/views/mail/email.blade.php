<x-correos-layout>
    <header style="box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);background-color:#FFFFFF">
        <div class="header">
            <h2 style="font-weight: 600; font-size: 1.25rem; color: #374151;">
            @if ($vista == 'incapacidad')
                <p>Nueva Incapacidad</p>
            @elseif ($vista == 'reporte') 
                <p>Reporte Atendido</p>
            @endif 
            </h2>
        </div>
    </header>
    
    @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        .header {
            max-width: 80rem; /* Equivalente a max-w-7xl en tailwindcss */
            margin-right: auto;
            margin-left: auto;
            padding-top: 1.5rem; /* Ajusta según tus necesidades */
            padding-right: 1rem; /* Ajusta según tus necesidades */
            padding-bottom: 1.5rem; /* Ajusta según tus necesidades */
            padding-left: 1rem; /* Ajusta según tus necesidades */
        }

        .container {
            padding-top: 3rem;
            max-width: 65rem;
            max-height: 80rem;
            margin: 0 auto;
        }

        .main-box {
            background-color: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
            margin-left: 4rem; /* Equivalent to ml-36 */
            width: 70%;
            margin-bottom: 20px;
        }

        .header-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 2rem;
            margin-top: 2rem;
            margin-right: auto;
            text-align:center;
            margin: 0 auto;
            align-items: center;
            width: 100%;
        }

        .header-section > div {
            margin-bottom: 2rem;
            margin-left: auto;
        }

        .title-label {
            color: #556575;
            font-weight: bold;
            font-size: 1.5rem;
            /* text-transform: uppercase; */
            margin-bottom: 1rem;
            width: 100%;
            margin-top: 1rem;
            
        }

        .content-section {
            margin-left: 4rem;
            margin-right: 1.5rem;
            margin-bottom: -40px;
        }
        .content-sectionf {
            margin-left: .9rem;
            margin-right: 1.5rem;
            margin-bottom: -40px;
        }

        .content-paragraph {
            text-align: justify;
            font-size: 1rem;
            color: #6B7280;
            margin-bottom: 2rem;
        }

        .content-paragraph2 {
            /* text-align: center; */
            margin-left: 3rem;
            font-size: 1rem;
            color: #6B7280;
            margin-bottom: 1rem;
        }

        .data-table {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            width: 100%;
        }

        .table th,
        .table td {
            text-align: center;
            border: 1px solid #383838;
            border-bottom: 1px solid #383838;
            padding: 0.5rem 1rem;
        }

        .table th {
            background-color: #2e934f;
            color: #FFFFFF;
        }

        .footer-section {
            margin-top: 1rem;
        }

        .footer-text {
            text-align: justify;
            margin-bottom: 2rem;
        }

        .footer-images {
            display: flex;
            flex-direction: column;
            margin-top: 2rem;
            margin-left: 2rem;
        }

        .footer-images a {
            margin-bottom: 3rem;
        }

        .footer-images img {
            border-radius: 0.5rem;
            transition: box-shadow 0.2s ease-in-out;
        }

        /* .footer-images a:hover img {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        } */

        .footer-images img:last-child {
            margin-top: 2rem;
            margin-left: 120px;
        }

    </style>
    @endsection

    <div class="container">
        <div class="main-box">
            <div class="header-section w-full">
                <p class="title-label">
                @if ($vista == 'incapacidad')
                    Nueva Incapacidad
                @elseif ($vista == 'reporte') 
                    Datos del Reporte                             
                @endif 
                </p>
            </div>
                <div>
                    <div class="content-section">
                        <p class="content-web">
                            @if ($vista == 'incapacidad')
                                La incapacidad ha sido realizada con exito.<br>
                                Ramo de seguro: <span class="content-paragraph font-bold text-xl">{{$ramo_de_seguro}}</span>&nbsp; 
                                &nbsp;Nombre del doctor: <span class="content-paragraph font-bold text-xl">{{$nombre_doctor}}</span><br>
                                Dias autorizados:<span style="font-weight: bold;"> {{ $dias_acumulados }} </span><br> 
                            @elseif ($vista == 'reporte') 
                                Nombre: <span class="content-paragraph font-bold text-xl">{{$nombre}}</span><br> 
                                El reporte ya ha sido atendido.&nbsp;
                                &nbsp;Fecha de deteccion del <span class="content-paragraph font-bold text-xl">{{$fechaDeteccion}}</span>&nbsp;                             
                            @endif 
                        </p>
                        @if ($vista == 'incapacidad')
                            <p class="content-paragraph2 font-bold text-xl">Datos de la Incapacidad:</p>
                        @elseif ($vista == 'reporte')
                            <p>Agradecemos su paciencia y colaboración mientras trabajábamos para resolver esta situación.</p>
                        @endif
                        <div class="data-table">
                            <table class="table">
                                <thead>
                                @if ($vista == 'incapacidad')
                                    <tr>
                                        <th style="width: 10%;">NOMBRE</th>
                                        <th style="width: 10%;">FECHA DE INICIO</th>
                                        <th style="width: 10%;">FECHA DE FIN</th>
                                    </tr>
                                @endif 
                                </thead>
                                <tbody>
                                @if ($vista == 'incapacidad')
                                    <tr>
                                        <td align="center" style="font-weight: bold;">{{$nombre}}</td>
                                        <td align="center">{{$fecha_inicio}}</td>
                                        <td align="center">{{$fecha_fin}}</td>
                                    </tr>
                                @endif 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <div class="content-sectionf">
                            @if ($vista == 'reporte') 
                                <p class="content-paragraph2">
                                Fecha en que se atendio: <span style="font-weight: bold;"> {{ $fechaAtendido }} </span><br> 
                                    <br><br>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>        
</x-correos-layout>
                    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>