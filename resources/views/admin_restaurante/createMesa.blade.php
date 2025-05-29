<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Mesa</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
        }

        form div {
            margin-bottom: 1rem;
        }

        label {
            font-weight: bold;
            display: block;
        }

        input {
            padding: 0.5rem;
            width: 100%;
            max-width: 300px;
        }

        button {
            padding: 0.5rem 1rem;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Crear Nueva Mesa</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin_restaurante.storeMesa') }}" method="POST">
        @csrf

        <div>
            <label for="capacidad">Capacidad:</label>
            <input type="number" name="capacidad" id="capacidad" min="1" required>
        </div>

        <button type="submit">Guardar Mesa</button>
    </form>
</body>
</html>
