<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Mesa</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Editar Mesa</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin_restaurante.updateMesa', $mesa->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="capacidad" class="form-label">Capacidad:</label>
                <input type="number" id="capacidad" name="capacidad" value="{{ old('capacidad', $mesa->capacidad) }}" class="form-control" required min="1" />
                <div class="invalid-feedback">
                    Por favor, ingresa una capacidad válida (mínimo 1).
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Mesa</button>
            <a href="{{ route('admin_restaurante.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional para validación y componentes) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Validación básica Bootstrap 5
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
