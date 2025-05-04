<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
    }

    .login-section {
      background: url('{{ asset('/img/res.jpg') }}') center center/cover no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }

    .login-box {
      background-color: #000000e6;
      border-radius: 30px;
      padding: 40px 30px;
      z-index: 2;
      text-align: center;
      width: 100%;
      max-width: 400px;
      color: white;
    }

    .login-box h2 {
      font-weight: bold;
      margin-bottom: 10px;
    }

    .login-box input {
      border-radius: 20px;
      padding: 10px 15px;
      margin-bottom: 15px;
    }

    .btn-orange {
      background-color: #ff6a00;
      border: none;
      padding: 10px 30px;
      color: white;
      font-weight: bold;
      border-radius: 25px;
    }

    .btn-orange:hover {
      background-color: #e55d00;
    }

    .register-link {
      margin-top: 15px;
      font-size: 0.9rem;
    }

    .register-link a {
      color: #ff6a00;
      text-decoration: none;
      font-weight: bold;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-section">
    <div class="overlay"></div>

    <div class="login-box position-relative">
      <h2>Iniciar Sesión</h2>
      <p class="mb-4">Escribe tus datos</p>

      <form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="email" class="form-control mb-3" name="correo" placeholder="Correo" required />
    @error('correo')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <input type="password" class="form-control mb-4" name="password" placeholder="Contraseña" required />
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-orange w-100">CONFIRMAR</button>
</form>
      <div class="register-link">
        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
      </div>
    </div>
  </div>

</body>
</html>
