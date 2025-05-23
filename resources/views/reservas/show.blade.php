<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1" />
    <title>Mis Reservas - ReservaYa!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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

        .hero-section {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 900;
        }

        .highlight {
            color: #ff6a00;
        }

        footer {
            text-align: center;
            color: white;
            padding: 15px;
            font-size: 0.85rem;
            background-color: rgba(0, 0, 0, 0.8);
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 10;
        }

        /* Estilos específicos para Mis Reservas */
        body.mis-reservas {
            background: url('{{ asset("img/reservado.jpg") }}') center center / cover no-repeat;
            color: #fff;
            padding-top: 80px;
            text-align: center;
        }

        h1.mis-reservas {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        ul.mis-reservas {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 0;
            margin: 0 auto;
            max-width: 100%;
        }

        li.mis-reservas {
            background-color: rgba(26, 26, 26, 0.85);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #ffffff33;
            text-align: center;
            font-weight: bold;
            width: 600px;
            list-style: none;
        }

        li.mis-reservas strong {
            color: #ff6a00;
        }

        
        .titulo-seccion {
            color: white;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 15px;
            display: block;
            margin: 0 auto;
        }

        p.mis-reservas {
            font-size: 1.1rem;
            color: #ddd;
            margin-top: 20px;
        }

        li.mis-reservas{
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-edit, .btn-delete {
            background-color: #ff6a00;
            border: none;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
            border-radius: 20px;
            font-style: italic;
            margin-top: 10px;
            display: inline-block; /* Para que estén en la misma línea */
            margin-right: 10px; /* Espacio entre botones */
            text-decoration: none; /* Quitar subrayado de enlaces */
        }

        .btn-edit:hover, .btn-delete:hover {
            background-color: #e55d00;
            color: white;
        }

    </style>
</head>
<body class="mis-reservas d-flex flex-column">
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

    <div class="container mt-5 flex-grow-1">
        <h1 class="titulo-seccion mb-5">MIS RESERVAS</h1>
        @if ($reservas->count() > 0)
            <ul class="mis-reservas">
                @foreach ($reservas as $reserva)
                    <li class="mis-reservas">
                        <strong>Número de reserva:</strong> {{ $reserva->id }}<br>
                        <strong>Nombre del Restaurante:</strong> {{ $reserva->restaurante->nombre }}<br>	
                        <strong>Mesa:</strong> {{ $reserva->mesa_id }}<br>
                        <strong>Fecha:</strong> {{ $reserva->fecha }}<br>
                        <strong>Hora:</strong> {{ $reserva->hora }}<br>
                        <strong>Número de Personas:</strong> {{ $reserva->num_personas }}<br>
                        <strong>Importe Reserva:</strong> {{ $reserva->importe_reserva }}
                        
                        <div class="mt-3">
                            <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn-edit">Editar</a>
                            <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta reserva?');">Eliminar</button>
                            </form>
                        </div>
                        <br>
                    </li>
                    
                @endforeach
            </ul>
        @else
            <p class="mis-reservas">No tienes reservas realizadas.</p>
        @endif
    </div>

    <footer class="bg-dark text-white text-center py-3">
        ReservaYa! - 2025. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
