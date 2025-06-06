<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Registro de Cliente | Veterinaria Lucite</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }
    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, rgba(255,245,240,0.95), rgba(240,248,255,0.95)), url('https://images.unsplash.com/photo-1534361960057-19889db9621e?q=80&w=1470&auto=format&fit=crop') no-repeat center center fixed;
      background-size: cover;
      overflow-x: hidden;
      color: #333;
    }
    .register-container {
      display: flex;
      max-width: 1000px;
      width: 90%;
      min-height: 600px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      background: white;
    }
    .info-panel {
      flex: 1;
      background: linear-gradient(135deg, #4b6cb7, #182848);
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }
    .info-panel::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\" fill=\"white\" opacity=\"0.05\"><path d=\"M30,10 Q50,5 70,20 T90,40 Q95,60 80,70 T60,90 Q40,95 30,80 T10,60 Q5,40 20,30 T30,10\"/></svg>');
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
    }
    .info-panel p { line-height: 1.6; opacity: 0.9; margin-bottom: 10px; }
    .features-list { list-style: none; margin-top: 20px; }
    .features-list li { padding-left: 30px; margin-bottom: 15px; position: relative; }
    .features-list li::before { content: "✓"; position: absolute; left: 0; color: #f59e0b; font-weight: bold; }
    .form-wrapper {
      width: 450px;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .form-group { margin-bottom: 18px; position: relative; }
    .form-group label { font-weight: 600; color: #064e3b; display: block; margin-bottom: 6px; }
    .form-group input {
      width: 100%; padding: 12px; border: 1.5px solid #e0e0e0;
      border-radius: 8px; background: #f9f9f9;
    }
    .form-group input:focus {
      border-color: #4b6cb7;
      background: white;
      outline: none;
      box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.2);
    }
    .message { font-size: 0.8rem; margin-top: 5px; color: #ef4444; display: none; }
    .message.success { color: #10b981; }
    .toggle-eye {
      position: absolute;
      top: 37px;
      right: 15px;
      cursor: pointer;
      color: #999;
    }
    .button-container { display: flex; gap: 10px; margin-top: 20px; }
    .register-button, .premium-button {
      padding: 12px; border-radius: 8px;
      font-weight: bold; border: none;
      cursor: pointer; flex: 1;
    }
    .register-button { background: linear-gradient(135deg, #4b6cb7, #3a56a0); color: white; }
    .premium-button { background: linear-gradient(135deg, #ff4500, #ff8c00); color: white; }
    @media (max-width: 768px) {
      .register-container { flex-direction: column; max-width: 450px; }
      .info-panel { display: none; }
      .form-wrapper { width: 100%; }
    }
  </style>
</head>
<body>
<div class="register-container">
  <div class="info-panel">
    <div class="info-content">
      <h2>Veterinaria Huellitas</h2>
      <p>Regístrate para acceder a nuestros beneficios:</p>
      <ul class="features-list">
        <li>Historial médico digital</li>
        <li>Recordatorios y citas</li>
        <li>Descuentos exclusivos</li>
        <li>Atención de emergencia</li>
        <li>Asesoría veterinaria 24/7</li>
      </ul>
    </div>
  </div>
  <div class="form-wrapper">
    <h2>Registrarse como Cliente</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required value="{{ old('name') }}">
      </div>
      <div class="form-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required value="{{ old('email') }}">
        <div id="email-status" class="message"></div>
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <i class="fas fa-eye toggle-eye" onclick="togglePassword('password', this)"></i>
        <div id="password-message" class="message">Debe tener mínimo 8 caracteres, mayúsculas, minúsculas, número y símbolo.</div>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <i class="fas fa-eye toggle-eye" onclick="togglePassword('password_confirmation', this)"></i>
        <div id="match-message" class="message success"></div>
      </div>
      <input type="hidden" name="role" value="cliente">
      <div class="button-container">
        <button type="submit" class="register-button" id="btn-registrar" disabled>REGISTRAR</button>
        <button type="button" class="premium-button" onclick="window.location='{{ route('login') }}'">VOLVER / LOGIN</button>
      </div>
    </form>
  </div>
</div>

<script>
  function validarPassword(pw) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(pw);
  }

  function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const btnRegistrar = document.getElementById('btn-registrar');
    const emailStatus = document.getElementById('email-status');
    const passwordMsg = document.getElementById('password-message');
    const matchMsg = document.getElementById('match-message');

    let emailOk = false;
    let passwordOk = false;
    let matchOk = false;

    function checkFormValid() {
      btnRegistrar.disabled = !(emailOk && passwordOk && matchOk);
    }

    emailInput?.addEventListener('input', () => {
      const email = emailInput.value;
      emailOk = false;
      emailStatus.textContent = '';
      if (email.length > 5 && email.includes('@')) {
        fetch('{{ route('verificar.email') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ email: email })
        })
        .then(res => res.json())
        .then(data => {
          if (data.exists) {
            emailStatus.textContent = '✖ Este correo ya está registrado';
            emailStatus.className = 'message error';
            emailOk = false;
            Swal.fire({
              icon: 'error',
              title: 'Correo en uso',
              text: 'Este email ya está registrado en el sistema.',
              confirmButtonColor: '#4b6cb7'
            });
          } else {
            emailStatus.textContent = '✔ Correo disponible';
            emailStatus.className = 'message success';
            emailOk = true;
          }
          checkFormValid();
        });
      }
    });

    passwordInput?.addEventListener('input', () => {
      const value = passwordInput.value;
      passwordOk = validarPassword(value);
      passwordMsg.style.display = passwordOk ? 'none' : 'block';

      matchOk = value === confirmInput.value && value !== '';
      matchMsg.textContent = matchOk ? '✔ Las contraseñas coinciden' : '';
      matchMsg.style.display = matchOk ? 'block' : 'none';

      checkFormValid();
    });

    confirmInput?.addEventListener('input', () => {
      matchOk = confirmInput.value === passwordInput.value && confirmInput.value !== '';
      matchMsg.textContent = matchOk ? '✔ Las contraseñas coinciden' : '';
      matchMsg.style.display = matchOk ? 'block' : 'none';
      checkFormValid();
    });
  });
</script>
</body>
</html>


