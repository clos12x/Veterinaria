@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-history"></i> Historial de Devoluciones</h4>
            <a href="{{ route('empleado.panel') }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow">
                <i class="fas fa-arrow-left"></i> Volver al Panel
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filtros -->
            <form method="GET" action="{{ route('empleado.devoluciones.index') }}" class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">🔍 Buscar por producto</label>
                    <input type="text" name="producto" class="form-control" value="{{ request('producto') }}" placeholder="Nombre del producto">
                </div>

                <div class="col-md-4">
                    <label class="form-label">👤 Registrado por</label>
                    <select name="usuario" class="form-select">
                        <option value="">Todos</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}" {{ request('usuario') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">📅 Rango de fechas</label>
                    <div class="input-group">
                        <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
                        <span class="input-group-text">a</span>
                        <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
                    </div>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary shadow"><i class="fas fa-filter"></i> Aplicar filtros</button>
                    <a href="{{ route('empleado.devoluciones.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i> Limpiar</a>
                </div>
            </form>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Lote</th>
                            <th>Producto</th>
                            <th>Venta</th>
                            <th>Cantidad</th>
                            <th>Motivo</th>
                            <th>Registrado por</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devoluciones as $dev)
                            <tr>
                                <td>{{ $dev->id }}</td>
                                <td>{{ $dev->codigo_lote ?? '-' }}</td>
                                <td>{{ $dev->producto->nombre ?? 'Producto eliminado' }}</td>
                                <td>#{{ $dev->venta->id }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $dev->cantidad }}</span></td>
                                <td>{{ $dev->motivo ?? '-' }}</td>
                                <td>{{ $dev->usuario->name ?? 'Usuario eliminado' }}</td>
                                <td>{{ \Carbon\Carbon::parse($dev->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle"></i> No hay devoluciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

