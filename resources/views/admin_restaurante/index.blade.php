<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de {{ $restaurante->nombre }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
    <h1>Administración de {{ $restaurante->nombre }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mt-4">
        <div class="card-header">
            Detalles del Restaurante
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $restaurante->nombre }}</p>
            <p><strong>Dirección:</strong> {{ $restaurante->direccion }}</p>
            <p><strong>Teléfono:</strong> {{ $restaurante->telefono ?? 'N/A' }}</p>
            <p><strong>Horario:</strong> {{ $restaurante->horario ?? 'N/A' }}</p>
            <p><strong>Creado en:</strong> {{ $restaurante->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última actualización:</strong> {{ $restaurante->updated_at->format('d/m/Y H:i') }}</p>

        
            {{-- Aquí podrías añadir enlaces para gestionar menús, mesas, etc. --}}

        </div>
    </div>
</div>
</body>
</html>

