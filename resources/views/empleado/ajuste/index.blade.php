@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">
        <h2 class="text-center text-primary mb-4">
            <i class="fas fa-sliders-h me-2"></i> Historial de Ajustes Manuales
        </h2>

        <!-- Botones de navegación -->
        <div class="d-flex justify-content-center gap-3 mb-4">
            <a href="{{ route('empleado.ajustes.create') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-sliders-h me-1"></i> Ajustes
            </a>
            <a href="{{ route('empleado.movimientos.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                <i class="fas fa-exchange-alt me-1"></i> Movimientos
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle mb-0 shadow-sm rounded-3 overflow-hidden">
    <thead class="bg-primary text-white">
        <tr>
            <th style="background-color: #0d6efd;">ID</th>
            <th style="background-color: #0d6efd;">Producto</th>
            <th style="background-color: #0d6efd;">Almacén</th>
            <th style="background-color: #0d6efd;">Tipo</th>
            <th style="background-color: #0d6efd;">Cantidad</th>
            <th style="background-color: #0d6efd;">Stock Actual</th>
            <th style="background-color: #0d6efd;">Glosa</th>
            <th style="background-color: #0d6efd;">Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ajustes as $ajuste)
            <tr style="background-color: #ffffff;">
                <td class="fw-bold text-muted">{{ $ajuste->id }}</td>
                <td class="fw-semibold text-dark">{{ $ajuste->producto }}</td>
                <td class="text-secondary">{{ $ajuste->almacen }}</td>
                <td>
                    <span class="badge {{ $ajuste->tipo === 'entrada' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($ajuste->tipo) }}
                    </span>
                </td>
                <td class="fw-bold text-primary">{{ $ajuste->cantidad }}</td>
                <td>
                    @if($ajuste->stock_actual !== null)
                        <span class="text-success fw-semibold">{{ $ajuste->stock_actual }}</span>
                    @else
                        <span class="text-muted">No registrado</span>
                    @endif
                </td>
                <td title="{{ $ajuste->glosa }}">
                    {{ \Illuminate\Support\Str::limit($ajuste->glosa, 30) }}
                </td>
                <td class="text-secondary">{{ \Carbon\Carbon::parse($ajuste->fecha)->format('d M Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-muted text-center">No hay ajustes registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
        </div>
    </div>
</div>
@endsection
