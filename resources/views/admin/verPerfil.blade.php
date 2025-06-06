@extends('layouts.app')

@section('content')
<style>
    .perfil-card {
        max-width: 900px;
        margin: 50px auto;
        border-radius: 20px;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .perfil-header {
        background-color: #0d9488;
        color: white;
        padding: 30px;
        text-align: center;
    }

    .perfil-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid white;
        margin-top: -75px;
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
    }

    .perfil-body {
        padding: 30px;
    }

    .perfil-info {
        font-size: 18px;
        margin: 10px 0;
    }

    .dark-mode .perfil-card {
        background: #1e293b;
        color: #f1f5f9;
    }

    .dark-mode .perfil-header {
        background-color: #164e63;
    }

    .modo-toggle {
        position: absolute;
        top: 20px;
        right: 30px;
        cursor: pointer;
        font-size: 1.4rem;
    }
</style>

<div class="perfil-card">
    <div class="perfil-header position-relative">
        <div class="modo-toggle" onclick="toggleModo()">
            <i id="icono-modo" class="fas fa-sun"></i>
        </div>
        <h2>Perfil del Administrador</h2>
    </div>

    <div class="text-center mt-4">
        {{-- Avatar generado automáticamente --}}
        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=256&background=0d9488&color=fff&bold=true" alt="Avatar" class="perfil-avatar">
    </div>

    <div class="perfil-body text-center">
        <div class="perfil-info"><strong>Nombre:</strong> {{ $admin->name }}</div>
        <div class="perfil-info"><strong>Correo:</strong> {{ $admin->email }}</div>
        <div class="perfil-info"><strong>Rol:</strong> {{ ucfirst($admin->role) }}</div>
        <div class="perfil-info"><strong>Registrado el:</strong> {{ $admin->created_at->format('d/m/Y H:i') }}</div>
    </div>
</div>

<script>
    function toggleModo() {
        const body = document.body;
        body.classList.toggle('dark-mode');

        const icon = document.getElementById('icono-modo');
        if (body.classList.contains('dark-mode')) {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        } else {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }

        localStorage.setItem('modo', body.classList.contains('dark-mode') ? 'dark' : 'light');
    }

    // Activar modo oscuro automático por hora o por preferencia del sistema
    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        const hours = now.getHours();
        const stored = localStorage.getItem('modo');

        if (stored === 'dark' || (!stored && (hours < 6 || hours >= 18))) {
            document.body.classList.add('dark-mode');
            document.getElementById('icono-modo').classList.remove('fa-sun');
            document.getElementById('icono-modo').classList.add('fa-moon');
        }
    });
</script>
@endsection
