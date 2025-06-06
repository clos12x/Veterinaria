@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">

    <!-- Encabezado y botones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold mb-0">
            <i class="fas fa-file-alt me-2"></i> Reporte de Compras
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.compras.reporte.pdf', request()->all()) }}"
               class="btn btn-danger rounded-pill fw-semibold">
                <i class="fas fa-file-pdf me-1"></i> Descargar PDF
            </a>
            <a href="{{ route('admin.dashboard') }}"
         class="btn btn-secondary rounded-pill fw-semibold">
         <i class="fas fa-arrow-left me-1"></i> Volver al Panel
         </a>
        </div>
    </div>

    <!-- Formulario de Filtros -->
    <form method="GET" action="{{ route('admin.compras.reporte') }}" class="card shadow-sm p-4 mb-4 bg-light rounded-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">📅 Fecha inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">📅 Fecha fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">🏢 Proveedor</label>
                <select name="id_proveedor" class="form-select">
                    <option value="">Todos</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ request('id_proveedor') == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                <i class="fas fa-search me-2"></i>Buscar
            </button>
        </div>
    </form>

    <!-- Tabla de Reporte -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle bg-white shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Total (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                    <tr>
                        <td>{{ $compra->id }}</td>
                        <td>{{ $compra->proveedor->nombre ?? 'Proveedor eliminado' }}</td>
                        <td>{{ $compra->fecha->format('d/m/Y H:i') }}</td>
                        <td>Bs {{ number_format($compra->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total General -->
    <h4 class="text-end text-success mt-4 fw-bold">
        Total General: Bs {{ number_format($total, 2) }}
    </h4>
</div>
@endsection
