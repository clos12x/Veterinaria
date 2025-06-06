@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<div class="container py-5" style="max-width: 1000px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4 flex-wrap gap-2">
            <h4 class="mb-0 d-flex align-items-center">
                <i class="fas fa-briefcase me-2"></i> Servicios Registrados
            </h4>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('empleado.index') }}" class="btn btn-outline-light fw-semibold shadow-sm">
                    <i class="fas fa-home me-1"></i> Volver al Panel
                </a>
                <a href="{{ route('empleado.servicio.create') }}" class="btn btn-light fw-semibold shadow-sm">
                    <i class="fas fa-plus-circle me-1"></i> Registrar Servicio
                </a>
            </div>
        </div>

        <div class="card-body bg-light">
            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success text-center shadow-sm fw-semibold">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Tabla de servicios --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center bg-white shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>📝 Nombre</th>
                            <th>📂 Tipo</th>
                            <th>💰 Precio</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servicios as $s)
                            <tr>
                                <td class="fw-semibold">{{ $s->nombre }}</td>
                                <td>{{ $s->tipo->nombre }}</td>
                                <td>Bs {{ number_format($s->precio, 2) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('empleado.servicio.destroy', $s->id) }}" onsubmit="return confirm('¿Eliminar este servicio?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted py-3 text-center">
                                    <i class="fas fa-info-circle"></i> No hay servicios registrados.
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
