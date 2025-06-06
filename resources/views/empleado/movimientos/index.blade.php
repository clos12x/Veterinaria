@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0 rounded-4 p-4 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold mb-0">
                <i class="fas fa-warehouse me-2"></i> Historial de Movimientos de Almacén
            </h2>
            <a href="{{ route('empleado.panel') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Volver al Panel
            </a>
        </div>

        <!-- Filtros -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-2">
                <label class="form-label fw-semibold">Tipo</label>
                <select name="tipo" class="form-select">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Almacén</label>
                <select name="id_almacen" class="form-select">
                    <option value="">Todos</option>
                    @foreach($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ request('id_almacen') == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Producto</label>
                <select name="id_producto" class="form-select">
                    <option value="">Todos</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ request('id_producto') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Desde</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Hasta</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-pill">
                    <i class="fas fa-search me-1"></i> Filtrar
                </button>
            </div>
        </form>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Almacén</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Responsable</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movimientos as $m)
                        <tr>
                            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $m->producto->nombre ?? 'Producto eliminado' }}</td>
                            <td>{{ $m->almacen->nombre ?? 'N/A' }}</td>
                            <td>
                                @switch($m->tipo)
                                    @case('entrada')
                                        <span class="text-success fw-bold">Entrada</span>
                                        @break
                                    @case('salida')
                                        <span class="text-danger fw-bold">Salida</span>
                                        @break
                                    @default
                                        {{ ucfirst($m->tipo) }}
                                @endswitch
                            </td>
                            <td>{{ $m->cantidad }}</td>
                            <td>{{ $m->usuario->name ?? 'Sistema' }}</td>
                            <td>{{ $m->detalle }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">No se encontraron movimientos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
