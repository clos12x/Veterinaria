@extends('layouts.app')

@section('content')
<style>
    :root {
        --sidebar-width: 260px;
    }

    body {
        overflow-x: hidden;
        background: linear-gradient(to bottom right, #e0f7fa, #ffffff);
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        background: linear-gradient(180deg, #0ea5e9, #0284c7);
        padding: 20px;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1050;
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .sidebar h4 {
        font-weight: bold;
    }

    .sidebar a {
        color: #fff;
        display: block;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 12px;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateX(5px);
    }

    .navbar-custom {
        height: 70px;
        background: linear-gradient(to right, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1100;
        transition: margin-left 0.3s ease;
    }

    .navbar-custom.shifted {
        margin-left: var(--sidebar-width);
    }

    .navbar-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
        color: white;
        font-weight: bold;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
        white-space: nowrap;
        transition: margin-left 0.3s ease;
    }

    .navbar-right.shifted {
        margin-right: var(--sidebar-width);
    }

    .menu-toggle {
        background-color: #fff;
        border: none;
        border-radius: 8px;
        width: 40px;
        height: 40px;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-content {
        margin-top: 90px;
        padding: 20px;
        transition: margin-left 0.3s ease;
    }

    .main-content.shifted {
        margin-left: var(--sidebar-width);
    }

    .navbar-right .btn {
        width: 45px;
        height: 45px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropdown-avatar:hover::after {
        content: "{{ Auth::user()->name }}";
        position: absolute;
        top: 50%;
        left: 110%;
        transform: translateY(-50%);
        background: #fff;
        color: #000;
        padding: 4px 8px;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .navbar-right {
            flex-shrink: 0;
            justify-content: flex-end;
        }
    }
</style>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <h4 class="text-white text-center mb-4"><i class="fas fa-stethoscope me-2"></i> Veterinario</h4>
    <a href="{{ route('veterinario.consulta.index') }}">
        <i class="fas fa-calendar-check me-2"></i> Consultas
        @if($consultasPendientes > 0)
            <span class="badge bg-danger ms-2">🔴</span>
        @endif
    </a>
</div>

{{-- Navbar superior ÚNICA --}}
<div class="navbar-custom" id="navbar">
    <div class="navbar-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars text-primary"></i>
        </button>
        <span>Veterinaria Huellitas</span>
    </div>

    <div class="navbar-right" id="navbarRight">
        {{-- Campana --}}
        <div class="dropdown">
            <button class="btn btn-light rounded-circle position-relative shadow-sm" data-bs-toggle="dropdown">
                <i class="fas fa-bell text-danger fs-5"></i>
                @if($consultasPendientes > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $consultasPendientes }}
                    </span>
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @if($consultasPendientes > 0)
                    <li>
                        <a class="dropdown-item text-danger fw-semibold" href="{{ route('veterinario.consulta.index') }}">
                            🔔 {{ $consultasPendientes }} consulta{{ $consultasPendientes > 1 ? 's' : '' }} pendiente{{ $consultasPendientes > 1 ? 's' : '' }}
                        </a>
                    </li>
                @else
                    <li><span class="dropdown-item text-muted">Sin consultas pendientes</span></li>
                @endif
            </ul>
        </div>

        {{-- Avatar --}}
        <div class="dropdown dropdown-avatar">
            <button class="btn btn-light rounded-circle fw-bold text-danger shadow-sm" data-bs-toggle="dropdown">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="{{ route('veterinario.perfil') }}"><i class="fas fa-user me-2"></i> Ver perfil</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit"><i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- Contenido principal --}}
<div id="mainContent" class="main-content container-fluid">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h4 class="text-primary fw-bold"><i class="fas fa-user-md me-2"></i> Panel de Veterinario</h4>
            <p class="text-muted mb-0">Acceso a tus funciones asignadas.</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-start border-4 border-primary shadow-sm p-4">
                <h5 class="text-primary"><i class="fas fa-notes-medical me-2"></i> Consultas</h5>
                <p class="text-muted">Revisa tus consultas asignadas.</p>
                <a href="{{ route('veterinario.consulta.index') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-eye me-1"></i> Ver Consultas
                </a>
            </div>
        </div>
    </div>
    @if($consultasPendientes > 0)
        <div class="alert alert-danger mt-4 shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Tienes {{ $consultasPendientes }} consulta{{ $consultasPendientes > 1 ? 's' : '' }} pendiente{{ $consultasPendientes > 1 ? 's' : '' }}.
        </div>
    @endif
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('mainContent');
        const navbarRight = document.getElementById('navbarRight');

        sidebar.classList.toggle('show');
        navbar.classList.toggle('shifted');
        content.classList.toggle('shifted');
        navbarRight.classList.toggle('shifted');
    }
</script>
@endsection















