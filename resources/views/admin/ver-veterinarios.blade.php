@extends('layouts.app')

@section('content')
<div class="container py-5" style="font-family: 'Poppins', sans-serif;">

    {{-- BOTÓN VOLVER AL PANEL --}}
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark shadow-sm px-4 py-2">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    {{-- ENCABEZADO --}}
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-gradient">🩺 Lista de Veterinarios</h2>
        <p class="text-muted">Gestión completa del equipo veterinario</p>
    </div>

    {{-- BUSCADOR --}}
    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.verVeterinarios') }}" class="row gy-2 gx-3 align-items-center justify-content-center">
                <div class="col-md-5">
                    <input type="text" name="busqueda" class="form-control form-control-lg"
                           placeholder="🔍 Buscar por nombre o email"
                           value="{{ request('busqueda') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-lg shadow">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.verVeterinarios') }}" class="btn btn-danger btn-lg shadow">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA DE VETERINARIOS --}}
    <div class="card shadow border-0 rounded-4">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark text-white">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($veterinarios as $vet)
                        <tr>
                            <td class="fw-semibold">{{ $vet->name }}</td>
                            <td>{{ $vet->email }}</td>
                            <td>{{ $vet->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.editarVeterinario', $vet->id) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️ Editar
                                    </a>
                                    <form action="{{ route('admin.eliminarVeterinario', $vet->id) }}"
                                          method="POST" onsubmit="return confirm('¿Eliminar este veterinario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4 fst-italic">
                                No se encontraron veterinarios.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ESTILOS PERSONALIZADOS --}}
<style>
    .text-gradient {
        background: linear-gradient(to right, #ec4899, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endsection

