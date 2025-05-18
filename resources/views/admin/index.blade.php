<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin - Restaurantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding-top: 60px; background: #f8f9fa; }
    .container { max-width: 900px; }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand">Panel Admin</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.index') }}">Restaurantes</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1>Administración de Restaurantes</h1>
      <a href="" class="btn btn-success">
        + Crear Restaurante
      </a>
    </div>

    @if($restaurantes->count())
      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Horario</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($restaurantes as $restaurante)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $restaurante->nombre }}</td>
                <td>{{ $restaurante->direccion }}</td>
                <td>{{ $restaurante->telefono }}</td>
                <td>{{ $restaurante->horario }}</td>
                <td>
                  <a href=""
                     class="btn btn-info btn-sm me-1">Ver</a>
                  <a href=""
                     class="btn btn-warning btn-sm me-1">Editar</a>
                  <form action=""
                        method="POST" class="d-inline"
                        onsubmit="return confirm('¿Eliminar restaurante?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-center">No hay restaurantes registrados.</p>
    @endif

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
