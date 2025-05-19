
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
          <h4 class="mb-0">Información del Restaunrante</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.update', ['restaurante' => $restaurante->id_restaurante]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-floating mb-3">
             <input type="text" name="nombre" class="form-control" value="{{ $restaurante->nombre }}" disabled>
              <label for="nombre">Nombre del Restaurante</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $restaurante->direccion }}" placeholder="Dirección" disabled>
              <label for="direccion">Dirección</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $restaurante->telefono }}" placeholder="Teléfono" disabled>
              <label for="telefono">Teléfono</label>
            </div>

            <div class="form-floating mb-4">
              <input type="text" name="horario" id="horario" class="form-control" value="{{ $restaurante->horario }}" placeholder="Horario" disabled>
              <label for="horario">Horario de Atención</label>
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Volver</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<body>
</html>