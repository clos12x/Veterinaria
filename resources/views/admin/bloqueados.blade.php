<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Usuarios Bloqueados</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-image: url('/img/imagen7.webp'); /* Ruta actualizada */
      background-size: cover;
      background-position: center;
      color: white; /* Cambia el color del texto para que sea legible sobre el fondo */
    }
    .container {
      background-color: rgba(0, 0, 0, 0.7); /* Fondo más oscuro para mejorar la legibilidad */
      padding: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Sombra para dar profundidad */
    }
  </style>
</head>
<body>
  <div class="container mx-auto max-w-4xl mt-10">
    <h1 class="text-3xl font-bold mb-6 text-center">Usuarios Bloqueados</h1>
    <p class="text-center mb-4">{{ session('message') }}</p>

    <!-- Mostrar el número de usuarios bloqueados -->
    <div class="text-center mb-4">
      @if($numBloqueados > 0)
        <p class="text-gray-300">Hay <span class="font-semibold">{{ $numBloqueados }}</span> usuarios bloqueados actualmente.</p>
      @else
        <p class="text-gray-300">No hay usuarios bloqueados por ahora.</p>
      @endif
    </div>

    <!-- Lista de usuarios bloqueados -->
    @if(!$bloqueados->isEmpty())
      <table class="table-auto w-full mt-4 bg-white text-black rounded-lg shadow-lg">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Intentos</th>
            <th class="px-4 py-2">Último Intento</th>
            <th class="px-4 py-2">Acción</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bloqueados as $usuario)
            <tr class="hover:bg-gray-100">
              <td class="border px-4 py-2">{{ $usuario->email }}</td>
              <td class="border px-4 py-2">{{ $usuario->attempts }}</td>
              <td class="border px-4 py-2">{{ $usuario->updated_at }}</td>
              <td class="border px-4 py-2">
                <form method="POST" action="{{ route('admin.desbloquear', ['email' => $usuario->email]) }}">
                  @csrf
                  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Desbloquear
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p class="text-gray-300 text-center">No hay usuarios bloqueados en este momento.</p>
    @endif

    <!-- Botón para volver al panel de administración -->
    <div class="mt-6 text-center">
      <a href="{{ route('admin.dashboard') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transition duration-300 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
        Volver al Panel de Administración
      </a>
    </div>
  </div>
</body>
</html>
