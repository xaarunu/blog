<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento de blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .container {
            border: 1px solid black;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }


        .logo img {
            width: 250px; /* Ajusta el tamaño de tu logo */
            height: auto;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .signature-line {
            height: 80px;
            border-top: 1px solid black;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .sub-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .col {
            flex-basis: 48%;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Logo -->
    <!-- Logo y Título -->
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <!-- Logo -->
            <td style="width: 40%;  padding: 10px; border:none;">
                <img src="{{ public_path('assets/cfe.png') }}" alt="Logo" style="width: 150px; height: auto;">
            </td>
    
            <!-- Título -->
            <td style="width: 60%; padding: 10px; border:none">
                <h2>MODULO BLOGS</h2>
                <p>{{ $blog->titulo }}</p>
                <p>BLOG RECUPERADO DEL USUARIO</p>
                <p>RPE: {{$blog->rpe}}</p>
            </td>
        </tr>
    </table>


    <!-- Hoja de Formalización -->
    <div class="sub-title">HOJA DE CONTENIDO</div>
    
    <table>
        <tr>
            <th>IMAGEN:</th>
            <td> 
                <img src="{{  public_path('storage/' . $blog->imagen) }}" alt="Imagen del blog" style="width: 200px; height: auto; margin-bottom: 1rem;">
            </td>
        </tr>
        <tr>
            <th>TEXTO:</th>
            <td> {{$blog->contenido}} </td>
        </tr>
        <tr>
            <th>FECHA:</th>
            <td>{{ date('d/m/Y') }}</td>
        </tr>
    
    </table>

    <!-- Espacio para firmas -->
    <div class="row">
        <div class="col">
            <p class="sub-title">AUTORIZACIÓN</p>
            <div class="signature-line">Reemplazar por nombre<br>Reemplazar por puesto</div>
            <div class="signature-line">Reemplazar por nombre<br>Reemplazar por puesto</div>
        </div>
        <div class="col">
            <p class="sub-title">REVISIÓN</p>
            <div class="signature-line">Reemplazar por nombre<br>Reemplazar por puesto</div>
            <div class="signature-line">Reemplazar por nombre<br>Reemplazar por puesto</div>
        </div>
    </div>

</div>

</body>
</html>
