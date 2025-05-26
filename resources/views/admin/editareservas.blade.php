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
            max-width: 900px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            text-align: center;
        }
        .table td {
            text-align: center;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .alert {
            margin-top: 20px;
        }
        .btn-danger {
            margin-left: 10px;
        }
        .btn-info {
            margin-left: 10px;
        }
        .btn-success {
            margin-left: 10px;
        }
        .btn-warning {
            margin-left: 10px;
        }
        .btn-primary {
            margin-left: 10px;
        }
        .btn-secondary {
            margin-left: 10px;
        }
        .btn-dark {
            margin-left: 10px;
        }
        .btn-light {
            margin-left: 10px;
        }
        .btn-link {
            margin-left: 10px;
        }
        .btn-outline-primary {
            margin-left: 10px;
        }
        .btn-outline-secondary {
            margin-left: 10px;
        }
        .btn-outline-success {
            margin-left: 10px;
        }  
    </style> 
</head>
<body>
    <div class="container">
    <h2>Editar Reserva #{{ $reserva->id }}</h2>
    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="restaurante_id" class="form-label">Restaurante</label>
            <select name="restaurante_id" id="restaurante_id" class="form-control" required>
                @foreach($restaurantes as $restaurante)
                    <option value="{{ $restaurante->id_restaurante }}" {{ $reserva->restaurante_id == $restaurante->id_restaurante ? 'selected' : '' }}>
                        {{ $restaurante->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="mesa_id" class="form-label">Mesa</label>
            <select name="mesa_id" id="mesa_id" class="form-control" required>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}" {{ $reserva->mesa_id == $mesa->id ? 'selected' : '' }}>
                        Mesa #{{ $mesa->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $reserva->fecha }}" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" name="hora" id="hora" class="form-control" value="{{ $reserva->hora }}" required>
        </div>

        <div class="mb-3">
            <label for="num_personas" class="form-label">Número de Personas</label>
            <input type="number" name="num_personas" id="num_personas" class="form-control" value="{{ $reserva->num_personas }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="importe_reserva" class="form-label">Importe Reserva</label>
            <input type="number" step="0.01" name="importe_reserva" id="importe_reserva" class="form-control" value="{{ $reserva->importe_reserva }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        <a href="{{ route('admin.reservas') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
