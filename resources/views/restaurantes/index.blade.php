<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restaurantes - ReservaYa!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: url('/img/res.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .restaurante-card {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 25px;
            color: white;
            padding: 20px;
            margin-bottom: 30px;
        }

        .restaurante-logo {
            width: 100px;
            height: auto;
        }

        .titulo-seccion {
            color: white;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 15px;
            display: block;
            margin: 0 auto;
        }

        .main-content {
            flex-grow: 1;
            padding-top: 120px;
        }

        footer {
            background-color: #323232;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 0.85rem;
        }

    </style>
</head>
<body class="d-flex flex-column">

<!-- Navbar fija -->
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
                <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('restaurantes.index') }}">Restaurantes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reservas.show') }}">Reservas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contacto</a></li>
                <li class="nav-item"><a class="nav-link">{{ Auth::user()->correo }}</a></li>
                <li class="nav-item"><a class="btn btn-orange" href="{{ route('logout') }}">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<main class="main-content">
    <div class="container py-5">
        <div class="text-center mb-5">
            <input type="text" class="form-control w-50 mx-auto buscador" placeholder="BUSCAR RESTAURANTE" id="searchInput">
        </div>

        <h2 class="titulo-seccion mb-5">RESTAURANTES DISPONIBLES:</h2>

        <!-- Verifica si hay restaurantes -->
        @if ($restaurantes->count() > 0)
            @foreach ($restaurantes as $restaurante)
            <div class="restaurante-wrapper">
                <div class="restaurante-card d-flex align-items-center mb-2">
                    <div class="me-4 text-center">
                        <img src="{{ asset('logos/' . strtolower(str_replace(' ', '', $restaurante->nombre)) . '.png') }}" alt="{{ $restaurante->nombre }}" class="restaurante-logo mb-2">
                        <br>
                        <a href="{{ route('reservas.form', $restaurante->id_restaurante) }}"class="btn btn-orange mt-2">Reservar</a>
                    </div>
                    <div>
                        <h4 class="mb-2">{{ $restaurante->nombre }}</h4>
                        <p class="mb-2">{{ $restaurante->direccion }} | Tel: {{ $restaurante->telefono }}</p>
                        <p class="mb-2">Horario: {{ $restaurante->horario }}</p>
                        <a href="#" class="text-info" data-bs-toggle="modal" data-bs-target="#modalCarta{{ $restaurante->id_restaurante }}">VER CARTA</a>
                    </div>
                </div>

                <!-- Modal Carta -->
                <div class="modal fade" id="modalCarta{{ $restaurante->id_restaurante }}" tabindex="-1" aria-labelledby="modalCartaLabel{{ $restaurante->id_restaurante }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCartaLabel{{ $restaurante->id_restaurante }}">Carta de {{ $restaurante->nombre }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $menusAgrupados = $restaurante->menu->groupBy('nombre_menu');
                                @endphp

                                @forelse ($menusAgrupados as $nombreMenu => $platos)
                                    <h5 class="text-warning mb-3">Menú de {{ $nombreMenu }}</h5>
                                    <ul class="list-unstyled mb-4">
                                        @foreach ($platos as $menu)
                                            <li class="mb-2">
                                                <strong>Plato:</strong> {{ $menu->nombre_plato }} ----
                                                <strong>Descripción:</strong> {{ $menu->descripcion_plato }} ----
                                                <strong>Precio:</strong> {{ number_format($menu->precio, 2) }} €
                                            </li>
                                        @endforeach
                                    </ul>
                                @empty
                                    <p>No hay elementos en la carta aún.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p>No hay restaurantes disponibles en este momento.</p>
        @endif
    </div>
</main>

<footer>
    ReservaYa! - 2025. Todos los derechos reservados.
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.trim().toLowerCase(); // Elimina espacios y convierte a minúsculas
            const wrappers = document.querySelectorAll('.restaurante-wrapper');

            wrappers.forEach(function (wrapper) {
                const nombre = wrapper.querySelector('h4')?.textContent.trim().toLowerCase() || ''; // Normaliza el texto
                wrapper.style.display = nombre.includes(filter) ? '' : 'none';
            });
        });
    });
</script>

</body>
</html>
