<html lang="es">
<head>
  <meta charset="utf-8"/>
  <title>Iniciar sesión </title>
  <style>
    /* Reset y base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, rgba(255,245,240,0.95), rgba(240,248,255,0.95)), 
                  url('https://images.unsplash.com/photo-1534361960057-19889db9621e?q=80&w=1470&auto=format&fit=crop') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      overflow-x: hidden;
      color: #333;
    }

    /* Contenedor principal */
    .login-container {
      display: flex;
      max-width: 900px;
      width: 90%;
      min-height: 500px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      background: white;
    }

    /* Panel de información */
    .info-panel {
      flex: 1;
      background: linear-gradient(135deg, #4b6cb7, #182848);
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .info-panel::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="white" opacity="0.05"><path d="M30,10 Q50,5 70,20 T90,40 Q95,60 80,70 T60,90 Q40,95 30,80 T10,60 Q5,40 20,30 T30,10"/></svg>');
      background-size: 150px;
      z-index: 1;
    }

    .info-content {
      position: relative;
      z-index: 2;
    }

    .info-panel h2 {
      font-size: 1.8rem;
      margin-bottom: 20px;
      font-weight: 600;
      color: white;
    }

    .info-panel p {
      margin-bottom: 15px;
      line-height: 1.6;
      opacity: 0.9;
    }

    .features-list {
      margin-top: 30px;
      list-style: none;
    }

    .features-list li {
      position: relative;
      padding-left: 30px;
      margin-bottom: 15px;
    }

    .features-list li::before {
      content: "✓";
      position: absolute;
      left: 0;
      color: #f59e0b;
      font-weight: bold;
    }

    /* Formulario de login */
    .login-wrapper {
      width: 380px;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: white;
      position: relative;
    }

    .logo {
      width: 100px;
      margin: 0 auto 25px;
      user-select: none;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    h2.login-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 25px;
      text-align: center;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group input {
      width: 100%;
      padding: 14px 45px 14px 14px;
      font-size: 0.95rem;
      border: 1.5px solid #e0e0e0;
      border-radius: 8px;
      background-color: #f9f9f9;
      transition: all 0.3s ease;
    }

    .input-group input:focus {
      outline: none;
      background-color: #fff;
      border-color: #4b6cb7;
      box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.2);
    }

    .input-group svg {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      width: 20px;
      height: 20px;
      color: #6b7280;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .input-group svg:hover {
      color: #4b6cb7;
    }

    .error {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 5px;
      font-weight: 500;
    }

    .btn-primary {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #4b6cb7, #3a56a0);
      color: white;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #3a56a0, #4b6cb7);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(75, 108, 183, 0.4);
    }

    .forgot-link {
      display: block;
      text-align: right;
      font-size: 0.85rem;
      color: #4b6cb7;
      margin-top: 10px;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .forgot-link:hover {
      color: #3a56a0;
      text-decoration: underline;
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 20px 0;
      color: #95a5a6;
      font-size: 0.85rem;
    }

    .divider::before, .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e0e0e0;
    }

    .divider::before {
      margin-right: 10px;
    }

    .divider::after {
      margin-left: 10px;
    }

    .social-buttons {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }

    .btn-social {
      flex: 1;
      padding: 12px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      font-weight: 500;
      color: white;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-google {
      background: #db4437;
    }

    .btn-facebook {
      background: #3b5998;
    }

    .btn-social:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-social img {
      width: 18px;
      margin-right: 8px;
    }

    .btn-secondary {
      width: 100%;
      padding: 12px;
      background: white;
      color: #4b6cb7;
      font-weight: 600;
      border: 1.5px solid #4b6cb7;
      border-radius: 8px;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 15px;
    }

    .btn-secondary:hover {
      background: #f5f7fa;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
        max-width: 450px;
      }

      .info-panel {
        display: none;
      }

      .login-wrapper {
        width: 100%;
        padding: 40px 30px;
      }
    }

    @media (max-width: 480px) {
      .login-wrapper {
        padding: 30px 20px;
      }

      .social-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <!-- Panel de información de la veterinaria -->
    <div class="info-panel">
      <div class="info-content">
        <h2>Veterinaria Huellitas</h2>
        <p>Cuidando a tus mascotas con amor y profesionalismo desde 2010.</p>
        
        <ul class="features-list">
          <li>Atención veterinaria 24/7</li>
          <li>Servicios de emergencia</li>
          <li>Cirugías especializadas</li>
          <li>Peluquería canina</li>
          <li>Farmacia veterinaria</li>
        </ul>
        
        <p style="margin-top: 30px;">📍 Av. la costa 34, Ciudad</p>
        <p>📞 (+591) 76453221</p>
        <p>✉ info@veterinarialucite.com</p>
      </div>
    </div>

    <!-- Formulario de login -->
    <div class="login-wrapper" role="main">
      <!-- Logo -->
      <img alt="Logo " class="logo" src="{{ asset('logo.Veterinaria.webp') }}"/>
      <h2 class="login-title">Iniciar Sesión</h2>
      
      <form action="{{ route('login') }}" method="POST" novalidate="">
        @csrf
        <div class="input-group">
          <input aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" 
                 aria-required="true" autocomplete="email" autofocus name="email" 
                 placeholder="Correo electrónico" required type="email" value="{{ old('email') }}"/>
          @if ($errors->has('email'))
            <div class="error" id="email-error" role="alert">
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>
        
        <div class="input-group">
          <input aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" 
                 aria-required="true" autocomplete="current-password" id="password" 
                 name="password" placeholder="Contraseña" required type="password"/>
          <svg onclick="togglePassword()" onkeypress="if(event.key==='Enter' || event.key===' ') togglePassword()" 
               role="button" tabindex="0" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
               stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
          @if ($errors->has('password'))
            <div class="error" id="password-error" role="alert">
              {{ $errors->first('password') }}
            </div>
          @endif
        </div>
        
        <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
        
        <button class="btn-primary" type="submit">
          Entrar
        </button>
      </form>
      
      <div class="divider">o continuar con</div>
      
      <div class="social-buttons">
        <a class="btn-social btn-google" href="{{ route('auth.google') }}">
          <img src="https://storage.googleapis.com/a1aa/image/1adcfa38-0061-42a9-7614-6e6f5d5a3aab.jpg" alt="Google"/>
          Google
        </a>
        <a class="btn-social btn-facebook" href="{{ route('auth.facebook') }}">
          <img src="https://storage.googleapis.com/a1aa/image/71f337e2-46ed-418a-9aaa-645bce27318f.jpg" alt="Facebook"/>
          Facebook
        </a>
      </div>
      
      <form action="{{ url('/') }}">
        <button class="btn-secondary" type="submit">
          Volver al inicio
        </button>
      </form>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      if (input.type === 'password') {
        input.type = 'text';
      } else {
        input.type = 'password';
      }
    }
  </script>
</body>
</html>









