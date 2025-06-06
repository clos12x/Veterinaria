@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success fw-bold"><i class="fas fa-paw me-2"></i>Tipos de Mascotas</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('empleado.tipoMascota.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Registrar Nuevo Tipo
            </a>
            <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-dark">
                <i class="fas fa-home me-1"></i> Volver al Panel
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>🐾 Nombre</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tipos as $tipo)
                            <tr class="text-center">
                                <td>{{ $tipo->nombre }}</td>
                                <td>
                                    <form method="POST" action="{{ route('empleado.tipoMascota.destroy', $tipo->id_tipoMascota) }}" onsubmit="return confirm('¿Eliminar este tipo de mascota?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash-alt me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">No hay tipos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
