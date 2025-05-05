<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio - ReservaYa!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
    }

    .hero-section {
      position: relative;
      height: 100vh;
      overflow: hidden;
    }

    .video-wrapper {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
    }

    .background-video {
      position: absolute;
      top: -60%; /* Ajustamos el video un poco para evitar bordes visibles */
      left: -50%;
      width: 200%; /* Doblamos el tamaño del video */
      height: 200%;
      object-fit: cover;
      filter: blur(8px);
      z-index: 0;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      z-index: 1;
    }

    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 2;
    }

    .logo img {
      width: 120px;
      height: auto;
    }

    .top-buttons {
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 2;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      top: 50%;
      transform: translateY(-50%);
      text-align: center;
    }

    .white-box {
      display: inline-block;
      background-color: white;
      padding: 20px 40px;
      border-radius: 8px;
    }

    .white-box h1 {
      font-weight: 900;
      font-size: 2.5rem;
      margin: 0;
      color: #000;
    }

    .highlight {
      color: #ff6a00;
    }

    .btn-orange {
      background-color: #ff6a00;
      border: none;
      color: white;
      padding: 10px 25px;
      font-weight: bold;
      border-radius: 25px;
    }

    .btn-orange:hover {
      background-color: #ffa600;
      color: white;
    }
  </style>
</head>
<body>
  <link rel="icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">

  <div class="hero-section">

    <div class="video-wrapper">
      <video autoplay loop muted playsinline class="background-video">
        <source src="{{ asset('img/34203-400954475.mp4') }}" type="video/mp4">
        Tu navegador no soporta video HTML5.
      </video>
    </div>

    <div class="overlay"></div>

    <div class="logo">
      <img src="{{ asset('img/Logo.png') }}" alt="Logo" width="120">
    </div>

    <div class="top-buttons d-flex gap-2">
      <a href="{{ route('login') }}">
        <button style="font-style: italic;" class="btn btn-orange">INICIAR SESIÓN</button>
      </a>
      <a href="{{ route('register') }}">
        <button style="font-style: italic;" class="btn btn-orange">REGÍSTRATE</button>
      </a>
    </div>

    <div class="container hero-content">
      <div class="white-box">
        <h1>ENCUENTRA. RESERVA.</h1>
        <h1><span class="highlight">DISFRUTA</span></h1>
      </div>
      <div class="mt-4">
      <a href="{{ route('index') }}">
        <button class="btn btn-orange">RESERVAR MESA AHORA</button>
      </a>
      </div>
    </div>

  </div>

</body>
</html>
