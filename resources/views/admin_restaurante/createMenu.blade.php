<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn-success {
            width: 100%;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }
        .mb-3 label {
            font-weight: bold;
        }
        .mb-3 textarea {
            height: 100px;
        }
        .mb-3 input[type="number"] {
            -moz-appearance: textfield;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
    </style>

</head>
<body>
    <div class="container">
    <h2>Crear Menú</h2>
    <form action="{{ route('admin_restaurante.storeMenu') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_menu">Nombre del Menú</label>
            <input type="text" name="nombre_menu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="descripcion_menu">Descripción</label>
            <textarea name="descripcion_menu" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="precio">Precio (€)</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
</body>
</html>