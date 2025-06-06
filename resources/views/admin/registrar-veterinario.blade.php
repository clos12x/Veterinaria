<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Formulario Registrar Veterinario</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    body {
      background-image: url('/img/imagen8.webp');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>
<body class="font-['Roboto']">
  <form class="w-11/12 sm:w-9/12 md:w-7/12 lg:w-5/12 xl:w-4/12 p-6 rounded-xl bg-gradient-to-br from-purple-600 to-blue-500 backdrop-blur-sm shadow-xl" method="POST" action="{{ route('admin.registrarVeterinario') }}">
    @csrf
    <div class="flex justify-center mb-4">
      <img src="/logo.Veterinaria.webp" alt="Logo" class="h-16 w-auto" />
    </div>
    <h2 class="text-white text-center font-bold text-2xl mb-6 select-none">Registrar Veterinario</h2>
    
    <!-- Contenedor con campos de entrada -->
    <div class="grid grid-cols-1 gap-4">
      <div class="flex gap-4 mb-4">
        <input
          type="text"
          name="name"
          placeholder="Nombre"
          class="flex-1 py-2 px-4 rounded-full text-gray-500 placeholder-gray-400 focus:outline-none"
          required
        />
        <input
          type="text"
          name="last_name"
          placeholder="Apellido"
          class="flex-1 py-2 px-4 rounded-full text-gray-500 placeholder-gray-400 focus:outline-none"
          required
        />
      </div>
    
      <input
        type="email"
        name="email"
        placeholder="Correo Electrónico"
        class="w-full mb-4 py-2 px-4 rounded-full text-gray-500 placeholder-gray-400 focus:outline-none"
        required
      />
    
      <!-- Contraseña -->
      <div class="relative mb-4">
        <input
          type="password"
          name="password"
          placeholder="Contraseña"
          class="w-full py-2 px-4 rounded-full text-gray-500 placeholder-gray-400 focus:outline-none"
          required
        />
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('password')">
          <i id="password-icon" class="fas fa-eye text-gray-500"></i>
        </span>
      </div>

      <!-- Confirmar Contraseña -->
      <div class="relative mb-4">
        <input
          type="password"
          name="password_confirmation"
          placeholder="Confirmar Contraseña"
          class="w-full py-2 px-4 rounded-full text-gray-500 placeholder-gray-400 focus:outline-none"
          required
        />
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('password_confirmation')">
          <i id="confirm-password-icon" class="fas fa-eye text-gray-500"></i>
        </span>
      </div>

      <button
        type="submit"
        class="w-full py-2 rounded-full bg-gradient-to-b from-cyan-400 to-blue-400 text-white font-semibold text-sm tracking-wide hover:brightness-110 transition"
      >
        Registrar Veterinario
      </button>
    </div>
  </form>

  <script>
    function togglePasswordVisibility(inputName) {
      const input = document.querySelector(`input[name="${inputName}"]`);
      const icon = document.getElementById(inputName === 'password' ? 'password-icon' : 'confirm-password-icon');
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
