<!DOCTYPE html>
 <html lang="es">
 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>ReservaYa! - Navegación</title>
   <title>Home - ReservaYa!</title>
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
       background: url('{{ asset("img/res.jpg") }}') center center / cover no-repeat;
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
             <a class="nav-link" href="#">Restaurantes</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="#">Reservas</a>
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
   <div class="hero-section">
     <div class="overlay"></div>
     <div class="container hero-content">
       <h1>EXPLORA <span class="highlight">SABORES</span> INCREÍBLES</h1>
       <p class="lead mt-3">Descubre y reserva en los mejores restaurantes de tu ciudad.</p>
       <a href="{{ route('index') }}" class="btn btn-orange mt-4">Reservar Ahora</a>
     </div>
   </div>
 
   <footer>
   ReservaYa! - 2025. Todos los derechos reservados.
 </footer>
 
 
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 </body>
 </html>