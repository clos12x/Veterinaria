<!-- PanelAdministrador.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel Administrador - Veterinaria Huellitas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .submenu { display: none; }
    .submenu.open { display: block; }
  </style>
</head>
<body class="bg-gray-100">
<!-- Sidebar -->
<aside id="sidebar" class="bg-gradient-to-b from-purple-800 via-blue-600 to-cyan-500 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 z-50 transition-transform duration-300 ease-in-out">
  <div class="text-center mb-6">
    <h1 class="text-2xl font-bold">Veterinaria</h1>
    <p class="text-sm text-white/80">Panel Admin</p>
  </div>
  <nav>

@php
  $permisoActivo = request()->is('admin/permisos*');
@endphp

<!-- Submenú de Roles/Permisos -->
<button onclick="toggleSubmenu('permisoSub')" class="w-full text-left py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
  <i class="fas fa-shield-alt mr-2"></i> Roles/Permisos <i class="fas fa-caret-down float-right"></i>
</button>
<div id="permisoSub" class="submenu ml-6 {{ $permisoActivo ? 'open' : '' }}">
  <a href="{{ route('admin.permissions.index') }}"
     class="block py-2 px-2 text-sm rounded {{ $permisoActivo ? 'bg-white text-purple-800 font-semibold' : 'hover:bg-white hover:text-purple-800' }}">
     Gestionar Permisos
  </a>
</div>


    <a href="{{ route('admin.bloqueados') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-lock mr-2"></i> Bloqueados
    </a>

    <!-- Submenú de Empleados -->
    <button onclick="toggleSubmenu('empleadoSub')" class="w-full text-left py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-users-cog mr-2"></i> Empleados <i class="fas fa-caret-down float-right"></i>
    </button>
    <div id="empleadoSub" class="submenu ml-6">
      <a href="{{ route('admin.formularioEmpleado') }}" class="block py-2 px-2 text-sm hover:bg-white hover:text-purple-800 rounded">Agregar Empleado</a>
      <a href="{{ route('admin.verEmpleados') }}" class="block py-2 px-2 text-sm hover:bg-white hover:text-purple-800 rounded">Ver Empleados</a>
    </div>

    <!-- Submenú de Veterinarios -->
    <button onclick="toggleSubmenu('veterinarioSub')" class="w-full text-left py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-user-md mr-2"></i> Veterinarios <i class="fas fa-caret-down float-right"></i>
    </button>
    <div id="veterinarioSub" class="submenu ml-6">
      <a href="{{ route('admin.formularioVeterinario') }}" class="block py-2 px-2 text-sm hover:bg-white hover:text-purple-800 rounded">Agregar Veterinario</a>
      <a href="{{ route('admin.verVeterinarios') }}" class="block py-2 px-2 text-sm hover:bg-white hover:text-purple-800 rounded">Ver Veterinarios</a>
    </div>

    <a href="{{ route('admin.clientes') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-users mr-2"></i> Clientes
    </a>

    <a href="{{ route('admin.compras.reporte') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-clipboard-list mr-2"></i> Reporte Compras
    </a>

    <a href="{{ route('admin.compras.reporte.pdf') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-file-pdf mr-2"></i> PDF Compras
    </a>

    <a href="{{ route('admin.reportes.index') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-chart-line mr-2"></i> Reporte General
    </a>

    <a href="{{ route('admin.reportes.pdf') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-file-alt mr-2"></i> PDF General
    </a>

    <a href="{{ url('/') }}" class="block py-2.5 px-4 rounded hover:bg-white hover:text-purple-800">
      <i class="fas fa-door-open mr-2"></i> Ir al Inicio
    </a>
  </nav>
</aside>



  <!-- Contenido -->
  <div id="mainContent" class="transition-all duration-300 ml-64 px-6 py-4">

    <!-- Header -->
    <header class="bg-white shadow p-4 flex items-center justify-between mb-6">
      <div class="flex items-center gap-4">
        <button id="hamburger" class="text-2xl text-gray-700">
          <i class="fas fa-bars"></i>
        </button>
       Bienvenido, {{ Auth::user()->name }}
      <span class="text-muted">({{ Auth::user()->role == 'administrador' || Auth::user()->hasPermission('administrador_total') ? 'Administrador' : ucfirst(Auth::user()->role) }})</span>
      </div>
      <div class="relative">
        <button onclick="toggleSubmenu('adminMenu')" class="flex items-center space-x-2">
          <img src="https://ui-avatars.com/api/?name=Admin" class="w-10 h-10 rounded-full border border-gray-300">
          <i class="fas fa-caret-down text-gray-600"></i>
        </button>
        <div id="adminMenu" class="submenu absolute right-0 mt-2 bg-white shadow-lg rounded w-40 z-50">
          <a href="{{ route('admin.verPerfil') }}" class="block px-4 py-2 hover:bg-gray-100">Ver Perfil</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </header>

    <!-- Tarjetas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
        <h3 class="text-xl font-bold mb-2">Clientes</h3>
        <p class="mb-4">Total: {{ $clientes }}</p>
        <a href="{{ route('admin.clientes') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ver Clientes</a>
      </div>
      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
        <h3 class="text-xl font-bold mb-2">Empleados</h3>
        <p class="mb-4">Total: {{ $empleados }}</p>
        <a href="{{ route('admin.verEmpleados') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ver Empleados</a>
      </div>
      <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
        <h3 class="text-xl font-bold mb-2">Veterinarios</h3>
        <p class="mb-4">Total: {{ $veterinarios }}</p>
        <a href="{{ route('admin.verVeterinarios') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ver Veterinarios</a>
      </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Productos Más Vendidos</h3>
        <canvas id="productosChart" height="180"></canvas>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Ganancias por Mes (Bs)</h3>
        <canvas id="gananciasChart" height="180"></canvas>
      </div>
    </div>

  </div>

  <!-- Scripts -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const hamburger = document.getElementById('hamburger');

    hamburger.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      sidebar.classList.toggle('hidden');
      mainContent.classList.toggle('ml-64');
    });

    function toggleSubmenu(id) {
      document.getElementById(id).classList.toggle('open');
    }
  </script>

  <script>
    const labelsProductos = {!! $labelsProductos !!};
    const valoresProductos = {!! $valoresProductos !!};
    const labelsMeses = {!! $labelsMeses !!};
    const gananciasPorMes = {!! $gananciasPorMes !!};

    new Chart(document.getElementById('productosChart'), {
      type: 'bar',
      data: {
        labels: labelsProductos,
        datasets: [{
          label: 'Cantidad Vendida',
          data: valoresProductos,
          backgroundColor: '#6366f1',
          borderRadius: 8
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });

    new Chart(document.getElementById('gananciasChart'), {
      type: 'line',
      data: {
        labels: labelsMeses,
        datasets: [{
          label: 'Ganancias',
          data: gananciasPorMes,
          fill: true,
          backgroundColor: 'rgba(16, 185, 129, 0.2)',
          borderColor: '#10b981',
          tension: 0.4
        }]
      },
      options: {
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>















