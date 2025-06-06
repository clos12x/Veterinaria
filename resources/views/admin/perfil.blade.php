<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Página de Perfil</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-image: url('/fondos/Fondo1-admin.webp'); /* Ruta actualizada a la imagen de fondo */
      background-size: cover;
      background-position: center;
    }
  </style>
</head>
<body class="bg-white text-gray-800 font-sans">
  <div class="max-w-md mx-auto p-6 bg-white bg-opacity-80 backdrop-blur-sm">
    <!-- Imagen de perfil -->
    <div class="flex justify-center mb-4">
      <img alt="Imagen de perfil" class="rounded-full w-20 h-20 object-cover" height="80" src="https://storage.googleapis.com/a1aa/image/c809edbf-2336-4537-28b5-f1e65bc0c0f3.jpg" width="80"/>
    </div>

    <!-- Información del perfil -->
    <div class="text-center">
      <h1 class="text-xl font-semibold mb-1">
        {{ $admin->name }}
      </h1>
      <p class="text-gray-500 mb-4">
        {{ $admin->email }}
      </p>
      <p class="text-sm text-gray-600 mb-4 px-4">
        Información del perfil del administrador, puede incluir detalles como roles, permisos, etc.
      </p>
      <button class="inline-flex items-center border border-gray-800 text-gray-800 text-sm font-semibold px-3 py-1 rounded hover:bg-gray-100 transition" type="button">
        Soy ADMIN
        <i class="fas fa-check ml-2"></i>
      </button>
    </div>

    <!-- Sección de detalles personales -->
    <div class="mt-6 space-y-2 text-gray-700 text-sm">
      <details class="border border-gray-300 rounded p-2">
        <summary class="cursor-pointer font-semibold">Nombre Completo</summary>
        <p class="text-gray-600 text-sm ml-4">{{ $admin->name }}</p>
      </details>
      <details class="border border-gray-300 rounded p-2">
        <summary class="cursor-pointer font-semibold">Correo Electrónico</summary>
        <p class="text-gray-600 text-sm ml-4">{{ $admin->email }}</p>
      </details>
      <details class="border border-gray-300 rounded p-2">
        <summary class="cursor-pointer font-semibold">Horario de trabajo</summary>
        <p class="text-gray-600 text-sm ml-4">Lunes - Viernes: 9:00 AM - 6:00 PM</p>
      </details>
    </div>

    <!-- Botón para volver al panel administrador -->
    <div class="mt-6 text-center">
      <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
        Volver al Panel Administrador
      </a>
    </div>
  </div>
</body>
</html>