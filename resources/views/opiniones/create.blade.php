<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dejar Opinión - {{ $restaurante->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('{{ asset("img/reservado.jpg") }}') center center / cover no-repeat fixed;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .navbar-brand img {
            width: 90px;
        }

        .nav-link {
            color: white !important;
            font-weight: bold;
            font-style: italic;
        }

        .nav-link:hover {
            color: #ff6a00 !important;
        }
        .btn-orange {
            background-color: #ff6a00;
            border: none;
            color: white;
            padding: 8px 20px;
            font-weight: bold;
            border-radius: 25px;
            font-style: italic;
        }
        .btn-orange:hover {
            background-color: #ffa600;
            color: white;
        }


        .main-content-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 280px;
            padding-bottom: 20px;
        }

        .opinion-card {
            background-color: rgba(26, 26, 26, 0.9);
            border-radius: 10px;
            padding: 30px;
            border: 1px solid #ffffff33;
            max-width: 900px;
            width: 100%;
            text-align: left;
            margin-bottom: 20px; /* Añade un margen inferior para separar del borde o del footer si se pega */
        }
        .opinion-card h1 {
            color: #ff6a00;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .form-label {
            color: #ddd;
            font-weight: bold;
        }
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #ffffff44;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #ff6a00;
            box-shadow: 0 0 0 0.25rem rgba(255, 106, 0, 0.25);
        }
        .rating-stars {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-bottom: 20px;
            direction: rtl; /* Para que las estrellas se muestren de derecha a izquierda */
        }
        .rating-stars label {
            font-size: 2em;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-stars input[type="radio"] {
            display: none;
        }
        .rating-stars input[type="radio"]:checked ~ label {
            color: gold;
        }
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: gold;
        }
        .alert {
            margin-top: 20px;
            text-align: center;
        }
        footer {
            text-align: center;
            color: white;
            padding: 15px;
            font-size: 0.85rem;
            background-color: rgba(0, 0, 0, 0.8);
            width: 100%;
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/Logo.png') }}" alt="Logo ReservaYa!">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('restaurantes.index') }}">Restaurantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservas.show') }}">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contacto</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <span class="nav-link">{{ Auth::user()->correo }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-orange" href="{{ route('logout') }}">Cerrar Sesión</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content-area">
        <div class="opinion-card">
            <h1>Dejar Opinión para {{ $restaurante->nombre }}</h1>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('opiniones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="restaurante_id" value="{{ $restaurante->id_restaurante }}">

                <div class="mb-3 text-center">
                    <label for="calificacion" class="form-label d-block mb-2">Calificación:</label>
                    <div class="rating-stars">
                        <input type="radio" id="star5" name="calificacion" value="5" required><label for="star5" title="5 estrellas">&#9733;</label>
                        <input type="radio" id="star4" name="calificacion" value="4"><label for="star4" title="4 estrellas">&#9733;</label>
                        <input type="radio" id="star3" name="calificacion" value="3"><label for="star3" title="3 estrellas">&#9733;</label>
                        <input type="radio" id="star2" name="calificacion" value="2"><label for="star2" title="2 estrellas">&#9733;</label>
                        <input type="radio" id="star1" name="calificacion" value="1"><label for="star1" title="1 estrella">&#9733;</label>
                    </div>
                    @error('calificacion')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario:</label>
                    <textarea class="form-control" id="comentario" name="comentario" rows="5" placeholder="Escribe tu opinión sobre el restaurante..." required></textarea>
                    @error('comentario')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-orange w-100">Enviar Opinión</button>
            </form>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        ReservaYa! - 2025. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>