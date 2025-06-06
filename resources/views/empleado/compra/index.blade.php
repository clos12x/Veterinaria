@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold mb-0">
                <i class="fas fa-boxes-stacked me-2"></i>Compras Registradas
            </h2>
            <a href="{{ route('empleado.panel') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i> Volver al Panel
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filtros -->
        <form method="GET" action="{{ route('empleado.compras.index') }}" class="row g-3 mb-4">
            <div class="col-md-5">
                <label for="proveedor" class="form-label fw-semibold">Proveedor:</label>
                <select name="proveedor" id="proveedor" class="form-select">
                    <option value="">Todos</option>
                    @foreach($proveedores as $prov)
                        <option value="{{ $prov->id }}" {{ request('proveedor') == $prov->id ? 'selected' : '' }}>
                            {{ $prov->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="almacen" class="form-label fw-semibold">Almacén:</label>
                <select name="almacen" id="almacen" class="form-select">
                    <option value="">Todos</option>
                    @foreach($almacenes as $alm)
                        <option value="{{ $alm->id }}" {{ request('almacen') == $alm->id ? 'selected' : '' }}>
                            {{ $alm->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-grid align-items-end">
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-search me-1"></i> Filtrar
                </button>
            </div>
        </form>

        <!-- Tabla de compras -->
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Almacén</th>
                        <th>Total (Bs)</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                            <td>{{ $compra->almacen->nombre }}</td>
                            <td>{{ number_format($compra->total, 2) }}</td>
                            <td>{{ $compra->fecha->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('empleado.compras.show', $compra->id) }}" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-1"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">No hay compras registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


