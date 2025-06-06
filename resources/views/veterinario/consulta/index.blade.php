@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="fas fa-notes-medical me-2"></i> Consultas Asignadas
        </h2>
        <a href="{{ route('veterinario.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- Alerta de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabla de Consultas -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Mascota</th>
                            <th>Motivo</th>
                            <th>Registrado por</th>
                            <th>Servicios Aplicados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            <tr>
                                <td>{{ $consulta->fecha }}</td>
                                <td>{{ $consulta->mascota->nombre }}</td>
                                <td>{{ $consulta->descripcion }}</td>
                                <td>{{ $consulta->empleado->name }}</td>
                                <td class="text-start">
                                    <ul class="mb-0 ps-3">
                                        @foreach($consulta->servicios as $servicio)
                                            <li>{{ $servicio->nombre }} - Bs {{ number_format($servicio->precio, 2) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('veterinario.consulta.servicio.create', $consulta->id_consulta) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus-circle me-1"></i> Agregar Servicio
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">No hay consultas asignadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
