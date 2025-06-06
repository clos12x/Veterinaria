@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #f8fafc, #e0f7fa);
        font-family: 'Segoe UI', sans-serif;
    }

    #sidebar {
        position: fixed;
        top: 60px;
        left: 0;
        height: 100%;
        width: 240px;
        background: linear-gradient(to bottom, #0d6efd, #6610f2);
        color: white;
        padding-top: 20px;
        transition: transform 0.3s ease;
        z-index: 1000;
    }

    #sidebar.hidden {
        transform: translateX(-100%);
    }

    #sidebar .nav-link {
        color: #fff;
        font-weight: 500;
        padding: 12px 20px;
        transition: all 0.3s;
    }

    #sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
    }

    .menu-toggle {
        cursor: pointer;
        font-size: 26px;
        border: none;
        background: none;
        color: #0d6efd;
        transition: transform 0.3s ease;
    }

    .menu-toggle:hover {
        transform: rotate(90deg);
    }

    .main-content {
        transition: margin-left 0.3s ease;
        margin-left: 240px;
        padding-top: 80px;
    }

    .main-content.full {
        margin-left: 0;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card img {
        height: 200px;
        object-fit: cover;
    }

    .btn-primary {
        background: linear-gradient(to right, #0d6efd, #6610f2);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #6610f2, #0d6efd);
    }

    footer {
        margin-top: 50px;
        color: #333;
    }

    @media (max-width: 992px) {
        #sidebar {
            width: 100%;
            height: auto;
            top: 60px;
        }

        .main-content {
            margin-left: 0 !important;
        }
    }
</style>

<div class="container-fluid">
    <!-- Navbar-->
    <nav class="navbar navbar-light bg-white shadow-sm fixed-top px-3">
        <div class="d-flex justify-content-between align-items-center w-100">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
                    @if(auth()->check())
                <h5 class="text-primary fw-bold mb-0">
                    <i class="fas fa-paw text-danger me-2"></i>Bienvenido, {{ auth()->user()->name }}
                </h5>
            @else
                <h5 class="text-muted mb-0">
                    <i class="fas fa-user me-2"></i>Invitado
                </h5>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('tienda.index') }}" class="nav-link">
                    <i class="fas fa-store me-2 text-warning"></i> Ver productos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cliente.historial.index') }}" class="nav-link">
                    <i class="fas fa-file-invoice me-2 text-info"></i> Historial de compras
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('cliente.direccion.index') }}" class="nav-link">
                    <i class="fas fa-map-marker-alt me-2 text-light"></i> Dirección de envío
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenido -->
    <div id="mainContent" class="main-content">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($productos as $producto)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}">
                            @else
                                <img src="{{ asset('img/default.jpg') }}" class="card-img-top" alt="Sin imagen">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-primary fw-bold">{{ $producto->nombre }}</h5>
                                <p class="card-text">{{ $producto->descripcion }}</p>
                               <p class="fw-bold text-success">Bs {{ number_format($producto->precio, 2, ',', '.') }}</p>
                                <a href="{{ route('tienda.index') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-shopping-cart me-1"></i> Ver Producto
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <footer class="text-center py-4">
                <p>🐾 Gracias por usar nuestro sistema 🐾</p>
            </footer>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('mainContent');
        sidebar.classList.toggle('hidden');
        content.classList.toggle('full');
    }
</script>
@endsection
