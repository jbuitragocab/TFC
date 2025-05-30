<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar menu</title>
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
        .btn-primary {
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
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Editar Menú</h2>
    <form action="{{ route('admin_restaurante.updateMenu', $menu->id_menu) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_menu">Nombre del Menú</label>
            <input type="text" name="nombre_menu" class="form-control" value="{{ $menu->nombre_menu }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion_menu">Descripción</label>
            <textarea name="descripcion_menu" class="form-control">{{ $menu->descripcion_menu }}</textarea>
        </div>
        <div class="mb-3">
            <label for="precio">Precio (€)</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="{{ $menu->precio }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
</body>
</html>