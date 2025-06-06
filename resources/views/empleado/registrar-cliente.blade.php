@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4 px-4">
            <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i> Registrar Cliente</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('empleado.verClientes') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Ver Clientes
                </a>
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-home me-1"></i> Panel
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('empleado.registrarCliente') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">👤 Nombre</label>
                    <input type="text" name="name" id="name" class="form-control rounded-pill" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">📧 Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-pill" required>
                </div>

                <div class="mb-4 position-relative">
                    <label for="password" class="form-label fw-semibold">🔒 Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control rounded-start-pill" required>
                        <button class="btn btn-outline-secondary rounded-end-pill" type="button" onclick="togglePassword()">
                            <i class="fas fa-eye" id="icono-ojo"></i>
                        </button>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-5 rounded-pill fw-semibold">
                        <i class="fas fa-save me-2"></i>Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ojito para contraseña -->
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icono = document.getElementById('icono-ojo');

    if (input.type === 'password') {
        input.type = 'text';
        icono.classList.remove('fa-eye');
        icono.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icono.classList.remove('fa-eye-slash');
        icono.classList.add('fa-eye');
    }
}
</script>
@endsection
