<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-success {
            margin-top: 10px;
        }
        .btn-secondary {
            margin-top: 10px;
        }
        .invalid-feedback {
            display: block;
        }
        .alert {
            margin-top: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
   <div class="container">
    <h1>Editar Información de {{ $restaurante->nombre }}</h1>

    <form action="{{ route('admin_restaurante.update') }}" method="POST">
        @csrf
        @method('PUT') {{-- Importante para el método PUT --}}

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Restaurante</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $restaurante->nombre) }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $restaurante->direccion) }}" required>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="number" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $restaurante->telefono) }}">
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="horario" class="form-label">Horario</label>
            <input type="text" class="form-control @error('horario') is-invalid @enderror" id="horario" name="horario" value="{{ old('horario', $restaurante->horario) }}">
            @error('horario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Agrega más campos si los necesitas --}}

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('admin_restaurante.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div> 
</body>
</html>
