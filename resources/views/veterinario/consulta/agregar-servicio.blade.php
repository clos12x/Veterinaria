@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Título y botón regresar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-gradient fw-bold">
            <i class="fas fa-notes-medical me-2"></i>Agregar Servicio a Consulta
        </h2>
        <a href="{{ route('veterinario.consulta.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-1"></i> Volver a Consultas
        </a>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Información de la consulta -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body bg-light">
            <p><strong>Mascota:</strong> {{ $consulta->mascota->nombre }}</p>
            <p><strong>Motivo de consulta:</strong> {{ $consulta->descripcion }}</p>
        </div>
    </div>

    <!-- Servicios ya aplicados -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-stethoscope me-2"></i>Servicios Aplicados
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($consulta->servicios as $servicio)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $servicio->nombre }}
                        <span class="badge bg-success">Bs {{ number_format($servicio->precio, 2) }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">No hay servicios aplicados aún.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Formulario para agregar servicio -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <form method="POST" action="{{ route('veterinario.consulta.servicio.store', $consulta->id_consulta) }}">
                @csrf {{-- ✅ Esto evita el error 419 --}}
                
                <div class="mb-4">
                    <label for="nombre" class="form-label fw-semibold">Nombre del Servicio</label>
                    <input type="text" id="nombre" name="nombre" class="form-control shadow-sm rounded-pill" required placeholder="Ej. Desparasitación">
                </div>

                <div class="mb-4">
                    <label for="precio" class="form-label fw-semibold">Precio (Bs)</label>
                    <input type="number" id="precio" name="precio" step="0.01" class="form-control shadow-sm rounded-pill" required placeholder="Ej. 50.00">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i>Guardar Servicio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(to right, #8e2de2, #4a00e0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endsection

