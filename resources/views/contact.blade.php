<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $problema = $_POST['problema'];

    $destino = "javierbc2223@gmail.com"; 
    $asunto = "Formulario de contacto de ReservaYa!";
    $mensaje = "Nombre: $nombre\nTeléfono: $telefono\nProblema: $problema";

    $headers = "From: no-reply@reservaya.com";

    if (mail($destino, $asunto, $mensaje, $headers)) {
        alert("Correo enviado correctamente.");
    } else {
        alert("Hubo un error al enviar el correo.") ;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contacto - ReservaYa!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: Arial, sans-serif;
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

    .contact-section {
      background: url('/img/res.jpg') center center/cover no-repeat;
      padding: 100px 0 60px;
      position: relative;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 1; /* permite que crezca y empuje el footer hacia abajo */
    }

    .contact-overlay {
      background-color: rgba(0, 0, 0, 0.8);
      padding: 40px;
      border-radius: 10px;
      max-width: 1100px;
      width: 100%;
    }

    .contact-info p,
    .contact-info a {
      margin: 0;
      font-size: 0.95rem;
    }

    .contact-info strong {
      display: block;
      margin-bottom: 5px;
    }

    .contact-info .highlight {
      color: #ff6a00;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 15px;
    }

    .btn-orange-form {
      background-color: #ff6a00;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 10px 30px;
      font-weight: bold;
    }

    .btn-orange-form:hover {
      background-color: #e55d00;
    }

    footer {
      text-align: center;
      color: white;
      padding: 15px;
      font-size: 0.85rem;
      background-color: rgba(0, 0, 0, 0.8);
    }

    hr {
      border-color: #555;
    }

    @media (max-width: 768px) {
      .contact-overlay {
        padding: 20px;
      }

      .contact-overlay .row {
        flex-direction: column;
      }
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">
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
          <li class="nav-item">
            <a class="nav-link">{{ Auth::user()->correo }}</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-orange" href="{{ route('logout') }}">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="contact-section">
    <div class="contact-overlay">
      <div class="row gx-5 gy-4 align-items-center">
        <!-- Información de contacto -->
        <div class="col-md-6 text-center text-md-start contact-info">
          <p class="mb-2">¿Tienes algún problema con la app?</p>
          <h4 class="fw-bold mb-3">Contáctanos</h4>
          <p><strong>Horario</strong>Servicio 24h/365 días del año.</p>
          <hr />
          <p><strong>Dirección</strong>
            Calle San Matín 123, SMV,<br>
            CP: 12345, Madrid, España.
          </p>
          <hr>
          <p><strong>Teléfono</strong> <span class="highlight">+34 635291923</span></p>
          <hr>
          <p><strong>Email</strong> <span class="highlight">reservaya@gmail.com</span></p>
          <hr>
          <p><strong>Redes sociales</strong>
            <span class="highlight">@reservaya</span>
          </p>
        </div>

        <!-- Formulario -->
        <div class="col-md-6 text-center text-md-start">
          <h4 class="fw-bold mb-2">¿Cuál es el problema?</h4>
          <p class="mb-4">Escríbenos contando qué ocurre.</p>
          <form action="{{ route('contact.send') }}" method="POST"  id="contactForm">
              @csrf
              <input type="text" class="form-control" placeholder="Nombre" name="nombre" required />
              <input type="text" class="form-control" placeholder="Correo / Teléfono de contacto" name="telefono" required />
              <textarea class="form-control" rows="4" placeholder="Problema" name="problema" required></textarea>
              <button  id="submitBtn" type="submit" class="btn btn-orange-form w-100 mt-3">ENVIAR FORMULARIO</button>
          </form>

        </div>
      </div>
    </div>
  </section>

  <footer>
    ReservaYa! - 2025. Todos los derechos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  
  <script>
  document.getElementById('contactForm').addEventListener('submit', function(event) {
    var submitButton = document.getElementById('submitBtn');

    // Deshabilitar el botón y cambiar el texto
    submitButton.disabled = true;
    submitButton.innerHTML = "Enviando...";
    event.preventDefault(); 

    // Espero 2 segundos antes de enviar el formulario
    setTimeout(function() {
      alert("Formulario enviado correctamente.");
      document.getElementById('contactForm').submit();
    }, 2000);
  });
</script>
</body>
</html>
