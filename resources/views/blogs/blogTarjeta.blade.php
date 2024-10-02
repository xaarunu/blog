<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <div class="
        @if ($blog->prioridad == 1) red 
        @elseif ($blog->prioridad == 2) yellow 
        @elseif ($blog->prioridad == 3) green 
        @endif;">
        
        <!-- Mostrar la imagen -->
        @if ($blog->imagen)
        <img src="{{  public_path('storage/' . $blog->imagen) }}" alt="Imagen del blog" style="width: 200px; height: auto; margin-bottom: 1rem;">
        @endif
        
        <h2><strong>{{ $blog->titulo }}</strong></h2>
        <p>{{ $blog->contenido }}</p>
        <p><strong>Autor RPE:</strong> {{ $blog->rpe }}</p>
        <p><em>Creado el: {{ $blog->created_at }}</em></p>
    </div>


</body>
</html>
