@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #f0f8ff, #e0f7fa);
        font-family: 'Segoe UI', sans-serif;
    }

    #sidebar {
        position: fixed;
        top: 60px;
        left: 0;
        width: 250px;
        height: 100%;
        background: linear-gradient(to bottom, #0d6efd, #6610f2);
        color: white;
        padding: 20px;
        z-index: 999;
        transition: transform 0.3s ease;
    }

    #sidebar.hidden {
        transform: translateX(-100%);
    }

    #sidebar a {
        color: #fff;
        display: block;
        margin: 10px 0;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #sidebar a:hover {
        transform: translateX(8px);
        color: #ffd700;
    }

    .menu-toggle {
        font-size: 26px;
        border: none;
        background: none;
        color: #0d6efd;
        cursor: pointer;
        margin-right: 15px;
    }

    .main-content {
        transition: margin-left 0.3s ease;
        margin-left: 260px;
        padding-top: 80px;
    }

    .main-content.full {
        margin-left: 0;
    }

    .producto-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        padding: 15px;
        width: 240px;
        transition: transform 0.3s ease;
    }

    .producto-card:hover {
        transform: translateY(-6px);
    }

    .producto-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
    }

    .btn-carrito {
        background: linear-gradient(to right, #198754, #28a745);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .btn-carrito:hover {
        background: linear-gradient(to right, #157347, #146c43);
    }

    .volver-btn {
        background: linear-gradient(to right, #6c757d, #343a40);
        color: white;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 500;
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
    <nav class="navbar navbar-light bg-white shadow-sm fixed-top px-3">
        <div class="d-flex justify-content-between align-items-center w-100">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('cliente.dashboard') }}" class="btn volver-btn">
                ← Volver al panel
            </a>
        </div>
    </nav>

    <!-- Sidebar Categorias -->
    <div id="sidebar" class="hidden">
        <h4 class="mb-3">Categorías</h4>
        <a href="{{ route('tienda.index') }}" onclick="toggleSidebar()">Todas</a>
        @foreach($categorias as $categoria)
            <a href="{{ route('tienda.index', ['categoria' => $categoria->id_categoria]) }}" onclick="toggleSidebar()">
                {{ $categoria->nombre }}
            </a>
        @endforeach
    </div>

    <!-- Contenido Principal -->
    <div id="mainContent" class="main-content full">
        <div class="container py-4">
            <div class="d-flex flex-wrap gap-4">
                @foreach($productos as $producto)
                    <div class="producto-card">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="producto-img">
                        @else
                            <img src="{{ asset('images/no-imagen.png') }}" alt="Sin imagen" class="producto-img">
                        @endif

                        <h5 class="mt-2 text-primary">{{ $producto->nombre }}</h5>
                        <p class="text-dark fw-semibold">Bs {{ number_format($producto->precio, 2, ',', '.') }}</p>

                        <p class="mb-2">
                            <strong>Stock total:</strong>
                            {{
                                $producto->almacenes->sum(function($almacen) {
                                    return $almacen->pivot->stock;
                                })
                            }} unidades
                        </p>

                        <form method="POST" action="{{ route('web.carrito.agregar') }}">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                            <input type="number" name="cantidad" value="1" min="1" class="form-control mb-2" style="width: 70px;">
                            <button type="submit" class="btn-carrito w-100">
                                🛒 Añadir al carrito
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
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

