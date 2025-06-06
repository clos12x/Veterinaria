<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Veterinaria Huellitas - Panel Empleado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    :root {
      --primary: #BE123C;
      --primary-dark: #9F1239;
    }
    body {
      background: #f8fafc;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
    }
    .sidebar {
      position: fixed;
      top: 56px;
      left: 0;
      width: 250px;
      height: calc(100vh - 56px);
      background: linear-gradient(160deg, var(--primary-dark), var(--primary));
      color: white;
      padding: 1rem;
      overflow-y: auto;
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      z-index: 1040;
    }
    .sidebar.show {
      transform: translateX(0);
    }
    .menu-group {
      margin-bottom: 1rem;
    }
    .menu-item {
      font-weight: bold;
      padding: 0.5rem 0.75rem;
      cursor: pointer;
      display: flex;
      align-items: center;
    }
    .menu-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }
    .submenu {
      display: none;
      padding-left: 1.5rem;
    }
    .menu-group:hover .submenu {
      display: block;
    }
    .submenu a {
      display: block;
      padding: 5px 0;
      color: white;
      text-decoration: none;
      font-size: 0.9rem;
    }
    .submenu a:hover {
      text-decoration: underline;
    }
    .main-content {
      padding: 2rem;
      margin-left: 0;
      transition: margin-left 0.3s ease;
    }
    .main-content.shifted {
      margin-left: 250px;
    }
    .card {
      border-left: 5px solid var(--primary);
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="btn btn-outline-danger" type="button" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </button>
    <span class="navbar-brand fw-bold text-danger ms-2">Veterinaria Huellitas</span>
    <div class="dropdown ms-auto">
      <img src="{{ Auth::user()->foto ? asset('img/empleados/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=BE123C&color=fff' }}" alt="Avatar" class="user-avatar">
      <a class="dropdown-toggle text-dark text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
        {{ Auth::user()->name }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('empleado.perfil') }}"><i class="fas fa-user me-2"></i>Perfil</a></li>
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
              <i class="fas fa-sign-out-alt me-2"></i>Salir
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div id="sidebar" class="sidebar">
  {{-- CLIENTES --}}
  @if(auth()->user()->hasPermission('clientes'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-users me-2"></i>Clientes</div>
    <div class="submenu">
      <a href="{{ route('empleado.verClientes') }}">Ver Clientes</a>
      <a href="{{ route('empleado.formularioCliente') }}">Registrar Cliente</a>
    </div>
  </div>
  @endif

  {{-- AJUSTES --}}
  @if(auth()->user()->hasPermission('Ajustes'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-cog me-2"></i>Ajustes</div>
    <div class="submenu">
      <a href="{{ route('empleado.ajustes.index') }}">Ver Ajustes</a>
      <a href="{{ route('empleado.ajustes.create') }}">Registrar Ajuste</a>
    </div>
  </div>
  @endif

  {{-- TIPO DE MASCOTA --}}
  @if(auth()->user()->hasPermission('mascota'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-paw me-2"></i>Tipo Mascota</div>
    <div class="submenu">
      <a href="{{ route('empleado.tipoMascota.index') }}">Ver Tipos</a>
      <a href="{{ route('empleado.tipoMascota.create') }}">Registrar Tipo</a>
    </div>
  </div>
  @endif

  {{-- MASCOTAS --}}
  @if(auth()->user()->hasPermission('mascota'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-dog me-2"></i>Mascotas</div>
    <div class="submenu">
      <a href="{{ route('empleado.mascota.index') }}">Ver Mascotas</a>
      <a href="{{ route('empleado.mascota.create') }}">Registrar Mascota</a>
    </div>
  </div>
  @endif

  {{-- CONSULTAS --}}
  @if(auth()->user()->hasPermission('consulta'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-stethoscope me-2"></i>Consultas</div>
    <div class="submenu">
      <a href="{{ route('empleado.consulta.create') }}">Ver Consultas</a>
    </div>
  </div>
  @endif
{{-- COBROS --}}
@if(auth()->user()->hasPermission('cobro'))
<div class="menu-group">
  <div class="menu-item"><i class="fas fa-wallet me-2"></i>Cobros</div>
  <div class="submenu">
    <a href="{{ route('empleado.cobros.index') }}">Ver Cobros</a>
  </div>
</div>
@endif


  {{-- PRODUCTOS --}}
  @if(auth()->user()->hasPermission('producto'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-box-open me-2"></i>Productos</div>
    <div class="submenu">
      <a href="{{ route('empleado.productos.index') }}">Ver Productos</a>
      <a href="{{ route('empleado.productos.create') }}">Registrar Producto</a>
    </div>
  </div>
  @endif

  {{-- CATEGORÍAS --}}
  @if(auth()->user()->hasPermission('categoria'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-folder-open me-2"></i>Categorías</div>
    <div class="submenu">
      <a href="{{ route('empleado.categorias.index') }}">Ver Categorías</a>
      <a href="{{ route('empleado.categorias.create') }}">Registrar Categoría</a>
    </div>
  </div>
  @endif

  {{-- ALMACÉN --}}
  @if(auth()->user()->hasPermission('stock'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-boxes me-2"></i>Almacén</div>
    <div class="submenu">
      <a href="{{ route('empleado.almacenes.stock') }}">Ver Stock</a>
      <a href="{{ route('empleado.almacen.create') }}">Registrar Almacén</a>
      <a href="{{ route('empleado.stock.create') }}">Registrar Stock</a>
      <a href="{{ route('empleado.almacenes.transferir') }}">Transferir Stock</a>
    </div>
  </div>
  @endif

  {{-- PROVEEDORES --}}
  @if(auth()->user()->hasPermission('proveedor'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-truck me-2"></i>Proveedores</div>
    <div class="submenu">
      <a href="{{ route('empleado.proveedores.index') }}">Ver Proveedores</a>
      <a href="{{ route('empleado.proveedores.create') }}">Registrar Proveedor</a>
    </div>
  </div>
  @endif
{{-- ÓRDENES --}}
@if(auth()->user()->hasPermission('ordenes'))
<div class="menu-group">
  <div class="menu-item"><i class="fas fa-list-check me-2"></i>Órdenes</div>
  <div class="submenu">
    <a href="{{ route('empleado.ordenes.index') }}">Ver Órdenes</a>
  </div>
</div>
@endif

  {{-- VENTAS --}}
  @if(auth()->user()->hasPermission('venta'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-cash-register me-2"></i>Ventas</div>
    <div class="submenu">
      <a href="{{ route('empleado.ventas.index') }}">Ver Ventas</a>
      <a href="{{ route('empleado.ventas.create') }}">Registrar Venta</a>
    </div>
  </div>
  @endif

  {{-- COMPRAS --}}
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-file-invoice-dollar me-2"></i>Compras</div>
    <div class="submenu">
      <a href="{{ route('empleado.compras.index') }}">Ver Compras</a>
      <a href="{{ route('empleado.compras.create') }}">Registrar Compra</a>
    </div>
  </div>

  {{-- DEVOLUCIONES --}}
  @if(auth()->user()->hasPermission('devolucion'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-undo me-2"></i>Devoluciones</div>
    <div class="submenu">
      <a href="{{ route('empleado.devoluciones.index') }}">Ver Devoluciones</a>
      <a href="{{ route('empleado.devoluciones.create') }}">Registrar Devolución</a>
    </div>
  </div>
  @endif

  {{-- MOVIMIENTOS --}}
  @if(auth()->user()->hasPermission('movimientos'))
  <div class="menu-group">
    <div class="menu-item"><i class="fas fa-right-left me-2"></i>Movimientos</div>
    <div class="submenu">
      <a href="{{ route('empleado.movimientos.index') }}">Ver Movimientos</a>
    </div>
  </div>
  @endif
</div>



<div id="mainContent" class="main-content">
  <h1 class="mb-4 text-danger fw-bold">Panel de Administración</h1>
<div id="mainContent" class="main-content">
  
  @php
    $tienePermisos = auth()->user()->permissions->count() > 0;
  @endphp
  <div class="row g-4">
    @if(!$tienePermisos || auth()->user()->hasPermission('cliente'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-users me-2"></i>Ver Clientes</h5>
        <p>Consulta la lista de clientes registrados.</p>
        <a href="{{ route('empleado.verClientes') }}" class="btn btn-primary">Ver Clientes</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('mascota'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-dog me-2"></i>Ver Mascotas</h5>
        <p>Consulta las mascotas registradas.</p>
        <a href="{{ route('empleado.mascota.index') }}" class="btn btn-primary">Ver Mascotas</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('consulta'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-file-medical-alt me-2"></i>Consultas</h5>
        <p>Consulta el historial de atenciones médicas.</p>
        <a href="{{ route('empleado.consulta.create') }}" class="btn btn-primary">Ver Consultas</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('producto'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-box-open me-2"></i>Productos</h5>
        <p>Consulta los productos disponibles.</p>
        <a href="{{ route('empleado.productos.index') }}" class="btn btn-primary">Ver Productos</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('categoria'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-folder-open me-2"></i>Categorías</h5>
        <p>Consulta las categorías de productos.</p>
        <a href="{{ route('empleado.categorias.index') }}" class="btn btn-primary">Ver Categorías</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('stock'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-boxes me-2"></i>Stock</h5>
        <p>Consulta el estado del stock en almacén.</p>
        <a href="{{ route('empleado.almacenes.stock') }}" class="btn btn-primary">Ver Stock</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('proveedor'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-truck me-2"></i>Proveedores</h5>
        <p>Consulta la lista de proveedores registrados.</p>
        <a href="{{ route('empleado.proveedores.index') }}" class="btn btn-primary">Ver Proveedores</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('venta'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-shopping-cart me-2"></i>Ventas</h5>
        <p>Consulta el historial de ventas.</p>
        <a href="{{ route('empleado.ventas.index') }}" class="btn btn-primary">Ver Ventas</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('compra'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-file-invoice-dollar me-2"></i>Compras</h5>
        <p>Consulta las compras realizadas.</p>
        <a href="{{ route('empleado.compras.index') }}" class="btn btn-primary">Ver Compras</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('devolucion'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-undo me-2"></i>Devoluciones</h5>
        <p>Consulta el historial de devoluciones.</p>
        <a href="{{ route('empleado.devoluciones.index') }}" class="btn btn-primary">Ver Devoluciones</a>
      </div>
    </div>
    @endif

    @if(!$tienePermisos || auth()->user()->hasPermission('movimientos'))
    <div class="col-md-6 col-lg-4">
      <div class="card p-3">
        <h5><i class="fas fa-right-left me-2"></i>Movimientos</h5>
        <p>Consulta el historial de movimientos de almacén.</p>
        <a href="{{ route('empleado.movimientos.index') }}" class="btn btn-primary">Ver Movimientos</a>
      </div>
    </div>
    @endif
  </div>
</div>

</div>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('mainContent');
    sidebar.classList.toggle('show');
    content.classList.toggle('shifted');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>