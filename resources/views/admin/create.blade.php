<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SuperAdmin - ReservaYa!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
          <h4 class="mb-0">Crear nuevo restaurante</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.store') }}" method="POST">
            @csrf

            <div class="form-floating mb-3">
              <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
              <label for="nombre">Nombre del Restaurante</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección" required>
              <label for="direccion">Dirección</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
              <label for="telefono">Teléfono</label>
            </div>

            <div class="form-floating mb-4">
              <input type="text" name="horario" id="horario" class="form-control" placeholder="Horario" required>
              <label for="horario">Horario de Atención</label>
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Cancelar</a>
              <button type="submit" class="btn btn-success">Guardar Restaurante</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
