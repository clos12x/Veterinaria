@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<div class="container py-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4 flex-wrap">
    <h3 class="mb-0 d-flex align-items-center">
        <i class="fas fa-dog me-2"></i> Lista de Mascotas
    </h3>

    <div class="d-flex gap-2">
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-light btn-sm">
            <i class="fas fa-home me-1"></i> Panel
        </a>
        <a href="{{ route('empleado.mascota.create') }}" class="btn btn-light text-success fw-semibold btn-sm shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Registrar
        </a>
    </div>
</div>

        <div class="card-body bg-light">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Formulario de búsqueda --}}
            <form method="GET" action="{{ route('empleado.mascota.index') }}" class="row g-3 align-items-end mb-4">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">🔎 Buscar por mascota o cliente:</label>
                    <input type="text" name="busqueda" class="form-control shadow-sm" placeholder="Ej: Max o Juan Pérez" value="{{ request('busqueda') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary shadow w-100">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('empleado.mascota.index') }}" class="btn btn-secondary shadow w-100">
                        <i class="fas fa-sync-alt"></i> Limpiar
                    </a>
                </div>
            </form>

            {{-- Tabla de mascotas --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center bg-white shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>🐾 Nombre</th>
                            <th>🎂 Edad</th>
                            <th>🐕‍🦺 Raza</th>
                            <th>📋 Tipo</th>
                            <th>👤 Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mascotas as $m)
                            <tr>
                                <td>{{ $m->nombre }}</td>
                                <td>{{ $m->edad }}</td>
                                <td>{{ $m->raza }}</td>
                                <td>{{ $m->tipo->nombre }}</td>
                                <td>{{ $m->cliente->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-3">
                                    <i class="fas fa-info-circle"></i> No hay mascotas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- FontAwesome --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>
@endsection
