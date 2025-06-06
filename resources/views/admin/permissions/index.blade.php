@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #f8f9fa, #e0f7fa);
    }

    .card-upgrade {
        border: none;
        border-radius: 2rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-upgrade:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.12);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        transition: all 0.3s ease-in-out;
    }

    .btn-glow {
        transition: all 0.3s ease-in-out;
    }

    .btn-glow:hover {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
        transform: scale(1.02);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        border-left: 6px solid #0d6efd;
        padding-left: 12px;
        margin-bottom: 1rem;
    }
</style>

<div class="container py-5 font-[Poppins]">

    <!-- Botón Volver -->
    <div class="mb-4 d-flex justify-content-start">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    <!-- Card Asignar Permiso -->
    <div class="card card-upgrade p-4 bg-white">
        <h4 class="section-title">
            👥 Asignar Permisos a un Usuario
        </h4>

        @if(session('success'))
            <div class="alert alert-success text-center fw-semibold">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.permissions.assign') }}" method="POST">
            @csrf

            <!-- Selector de usuario -->
            <div class="mb-4">
                <label for="user_id" class="form-label fw-semibold">Selecciona un Usuario</label>
                <select name="user_id" class="form-select rounded-pill shadow-sm" required>
                    <option value="" disabled selected>-- Elegir Usuario --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Permisos en columnas -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-4">
                @foreach($permissions as $permission)
                    @if($permission->name && !in_array(strtolower($permission->name), ['cliente', 'ajuste']))
                    <div class="col">
                        <div class="form-check bg-light p-3 rounded-4 shadow-sm h-100">
                            <input class="form-check-input"
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                id="{{ strtolower($permission->name) === 'administrador_total' ? 'permiso-admin' : 'permiso-'.$permission->id }}"
                                {{ isset($selectedPermissions) && in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="{{ strtolower($permission->name) === 'administrador_total' ? 'permiso-admin' : 'permiso-'.$permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- Botón asignar -->
            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary btn-glow rounded-pill fw-bold">
                    <i class="fas fa-share-square me-2"></i> Asignar Permisos al Usuario
                </button>
            </div>
        </form>

        <!-- Formulario Crear Nuevo Permiso -->
        <hr class="my-4">
        <h5 class="text-center mb-3 fw-semibold">➕ Crear Nuevo Permiso</h5>

        <form action="{{ route('admin.permissions.store') }}" method="POST" class="d-flex gap-3 justify-content-center">
            @csrf
            <input type="text" name="name" class="form-control w-50 rounded-pill shadow-sm" placeholder="Nombre del nuevo permiso" required>
            <button type="submit" class="btn btn-outline-success btn-glow rounded-pill">
                <i class="fas fa-plus-circle me-1"></i> Crear Permiso
            </button>
        </form>
    </div>
</div>

<!-- Script para bloquear otros permisos si se marca administrador_total -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const adminCheckbox = document.querySelector('#permiso-admin');
    const allCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

    function toggleCheckboxes() {
        if (adminCheckbox && adminCheckbox.checked) {
            allCheckboxes.forEach(cb => {
                if (cb !== adminCheckbox) {
                    cb.checked = false;
                    cb.disabled = true;
                }
            });
        } else {
            allCheckboxes.forEach(cb => cb.disabled = false);
        }
    }

    if (adminCheckbox) {
        adminCheckbox.addEventListener('change', toggleCheckboxes);
        toggleCheckboxes();
    }
});
</script>
@endsection



