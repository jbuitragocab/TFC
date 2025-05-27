<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Editar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* Espacio para el navbar fijo */
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            max-width: 700px; /* Ajustado para un formulario */
            flex-grow: 1; /* Permite que el contenedor crezca y empuje el footer */
            padding-bottom: 20px; /* Espacio antes del footer */
        }
        .form-control, .form-select {
            border-radius: 0.375rem; /* Bootstrap default rounded corners */
        }
        .alert {
            margin-top: 20px;
        }
        .navbar {
            background-color: #343a40 !important; /* Dark background for navbar */
        }
        .navbar-brand {
            color: #fff !important;
        }
        .nav-link {
            color: #fff !important;
        }
        .nav-link:hover {
            color: #ffc107 !important; /* Yellowish hover for nav links */
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #343a40; /* Dark background for footer */
            color: white;
            width: 100%;
            margin-top: auto; /* Empuja el footer al final de la página */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Panel Admin</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.index') }}">Restaurantes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.reservas') }}">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('restaurantes.index') }}">Vista Usuario</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Editar Reserva #{{ $reserva->id }}</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Campo usuario_id eliminado del formulario --}}
            {{-- Puedes mantenerlo como un campo oculto si necesitas enviarlo pero no modificarlo visualmente --}}
            <input type="hidden" name="usuario_id" value="{{ $reserva->usuario_id }}">

            <div class="mb-3">
                <label for="restaurante_id" class="form-label">Restaurante</label>
                <select name="restaurante_id" id="restaurante_id" class="form-select" required>
                    @foreach($restaurantes as $restaurante)
                        <option value="{{ $restaurante->id_restaurante }}" {{ $reserva->restaurante_id == $restaurante->id_restaurante ? 'selected' : '' }}>
                            {{ $restaurante->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('restaurante_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mesa_id" class="form-label">Mesa</label>
                <select name="mesa_id" id="mesa_id" class="form-select" required>
                    @foreach($mesas as $mesa)
                        <option value="{{ $mesa->id }}" {{ $reserva->mesa_id == $mesa->id ? 'selected' : '' }}>
                            Mesa #{{ $mesa->identificador ?? $mesa->id }} (Capacidad: {{ $mesa->capacidad }})
                        </option>
                    @endforeach
                </select>
                @error('mesa_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $reserva->fecha) }}" required>
                @error('fecha')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" name="hora" id="hora" class="form-control" value="{{ old('hora', $reserva->hora) }}" required>
                @error('hora')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="num_personas" class="form-label">Número de Personas</label>
                <input type="number" name="num_personas" id="num_personas" class="form-control" value="{{ old('num_personas', $reserva->num_personas) }}" min="1" required>
                @error('num_personas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="importe_reserva" class="form-label">Importe Reserva</label>
                <input type="number" step="0.01" name="importe_reserva" id="importe_reserva" class="form-control" value="{{ old('importe_reserva', $reserva->importe_reserva) }}">
                @error('importe_reserva')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
            <a href="{{ route('admin.reservas') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <footer>
        ReservaYa! - 2025. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
