<!DOCTYPE html>
<html>

<head>
    <style>
        :root {
            font-family: 'Nunito';
            color: #303438;
            margin: 0;
        }

        .container {
            max-width: 45rem;
            margin: 2rem auto;
            margin-top: 0;
            background-color: #f5f5f5;
            padding: 0.5rem 1rem;
        }

        h1 {
            padding: 0 1.5rem;
            font-weight: bold;
            color: #2e934f;
        }

        h2 {
            max-width: 45rem;
            font-weight: bold;
            text-align: center;
            background-color: #2e934f;
            color: #fff;
            border-radius: .3rem;
            letter-spacing: .2rem;
            font-style: italic;
            padding: 0 1rem;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        h3 {
            margin-top: 0;
            font-size: 1rem;
            font-weight: normal;
        }

        p {
            font-size: .9rem;
        }

        a {
            display: block;
            width: max-content;
            padding: .3rem .9rem;
            border-radius: .3rem;
            background-color: #2e934f;
            font-size: .9rem;
            font-weight: bold;
            margin: 0 auto;
        }

        .codigo {
            padding: .3rem .6rem;
            border-radius: .3rem;
            background-color: #2e934f;
            color: #fff;
            font-style: italic;
            font-weight: bold;
            letter-spacing: .1rem;
        }

        img {
            display: block;
            width: 250px;
            margin: 0 auto;
        }

        .remitente {
            display: block;
            margin: 0 auto;
            font-weight: bold;
            width: max-content;
            margin-top: .5rem;
        }

        .center {
            display: flex;
            justify-content: center;
        }

        .footer-section {
            margin-top: 1rem;
        }

        .custom-line {
            border: none;
            height: 5px;
            background-color: #2e934f;
        }

        .footer-text {
            font-weight: bold;
            color: #2e934f;
            font-style: italic;
            text-align: right;
            font-size: .9rem;
        }
    </style>
</head>

<body>
    <h1>Código para Actualización de Contraseña</h1>
    <h2 style="margin: 0 auto;">CFE</h2>
    <div class="container">
        <div class="content-section">
            <h3>Estimado/a <strong>{{ $user_name }}</strong>.</h3>
            <p>
                Le informamos que, a solicitud suya, hemos generado un código de seguridad para la actualización de su
                contraseña por defecto en nuestro sistema <strong>CFE Bienestar</strong>. Este código es necesario para
                completar el proceso de cambio de contraseña y
                asegurar la protección de su cuenta.</p>
            <p>
                <strong>Código de Seguridad:</strong> <span class="codigo">{{ $code }}</span>
            </p>
            <p>
                <strong>Fecha de expiración:</strong> {{ $expiration }}
            </p>
            <p>Para actualizar su contraseña, por favor ingrese a nuestra página para concluir con el tramite:</p>
            <a href="{{ route('change.password') }}" style="color: #fff;">Ir al sitio</a>
            <p>Si usted <strong>no ha solicitado</strong> este cambio, por favor póngase en contacto con nuestro equipo
                de soporte
                inmediatamente para asegurar la protección de su cuenta.</p>
            <p>Agradecemos su atención y quedamos a su disposición para cualquier consulta o asistencia adicional que
                pueda necesitar.</p>
            <p>Saludos cordiales, Atentamente.</p>
            <div>
                <img src="{{ $message->embed(public_path('assets/SCI.png')) }}" alt="Sistema de Control Interno">
                <p class="remitente">Oficinas de Control Interno</p>
            </div>
        </div>
        <div class="footer-section">
            <hr class="custom-line">
            <div class="footer-text">Tus valores solo se ven a traves de tus acciones</div>
        </div>
    </div>
</body>

</html>
