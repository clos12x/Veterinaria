<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Veterinaria Huellitas, cuidado y bienestar para tus mascotas." />
    <meta name="author" content="Veterinaria Huellitas" />
    <meta name="robots" content="index, follow" />
    
    <!-- Título personalizado -->
    <title>Veterinaria Huellitas</title>

    <!-- Ícono personalizado (favicon) -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- ✅ Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite CSS y JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen">
        <!-- NAVBAR SIMPLE -->
        <nav class="bg-white border-b border-gray-200 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="text-lg font-bold text-orange-600">
                    Veterinaria Huellitas
                </div>

                <!-- Contenido de usuario -->
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                        <!-- Botón de Cerrar Sesión -->
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                         @csrf
                          <button type="submit"
                             class="btn btn-danger btn-sm px-3 py-1 rounded shadow-sm"
                             style="font-weight: 500;">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión
                         </button>
                        </form>
                    @endauth

                    @guest
                        <!-- Si el usuario no está autenticado, mostrar enlace a login -->
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Iniciar sesión</a>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- CONTENIDO DEL DASHBOARD -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content') <!-- Aquí se inyecta el contenido de cada vista -->
            </div>
        </main>
    </div>

    <!-- Scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <!-- Alerta de éxito SIN redirección -->
@if(session('success'))
<script>
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session("success") }}',
        icon: 'success',
        confirmButtonText: 'OK',
        timer: 2000,
        timerProgressBar: true
    });
</script>
@endif

<!-- Alerta de error SIN redirección -->
@if(session('error'))
<script>
    Swal.fire({
        title: '¡Error!',
        text: '{{ session("error") }}',
        icon: 'error',
        confirmButtonText: 'OK',
        timer: 2000,
        timerProgressBar: true
    });
</script>
@endif
</body>
</html>
