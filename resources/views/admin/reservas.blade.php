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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand">Panel Admin</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.index') }}">Restaurantes</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.reservas') }}">Reservas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('restaurantes.index') }}">Vista Usuario</a></li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container">
    <h2 class="mb-4">Todas las Reservas</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Restaurante</th>
                    <th>Mesa</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Nº Personas</th>
                    <th>Importe</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->id }}</td>
                        <td>{{ $reserva->user->correo ?? 'No disponible'}}</td>
                        <td>{{ $reserva->restaurante->nombre ?? 'No disponible' }}</td>
                        <td>{{ $reserva->mesa->id ?? 'No disponible' }}</td>
                        <td>{{ $reserva->fecha }}</td>
                        <td>{{ $reserva->hora }}</td>
                        <td>{{ $reserva->num_personas }}</td>
                        <td>{{ $reserva->importe_reserva }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('admin.editareservas', $reserva->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta reserva?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
