@extends('layouts.app')

@section('content')
<div class="container">

    <!-- 🔙 Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
            ← Volver al panel
        </a>
    </div>

    <h2 class="text-center mb-4">📦 Órdenes de Envío</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Tipo de entrega</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Recibo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordenes as $orden)
                    <tr>
                        <td>{{ $orden->id }}</td>
                        <td>{{ $orden->venta->cliente->name ?? 'Sin cliente' }}</td>
                        <td>
                            @if($orden->tipo_entrega === 'delivery')
                                <span class="badge bg-info">🛵 Delivery</span>
                            @else
                                <span class="badge bg-secondary">🏥 Retiro</span>
                            @endif
                        </td>
                        <td>
                            @if($orden->tipo_entrega === 'delivery' && $orden->direccion)
                                <strong>{{ $orden->direccion->direccion }}</strong><br>
                                {{ $orden->direccion->zona }} - {{ $orden->direccion->ciudad }}<br>
                                <small class="text-muted">
                                    🔑 {{ $orden->direccion->referencia }}<br>
                                    📞 {{ $orden->direccion->telefono }}
                                </small>
                            @else
                                <span class="text-muted">No aplica</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('empleado.ordenes.actualizarEstado', $orden->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="estado" onchange="this.form.submit()" class="form-select">
                                    <option value="pendiente" {{ $orden->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en camino" {{ $orden->estado === 'en camino' ? 'selected' : '' }}>En camino</option>
                                    <option value="entregado" {{ $orden->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('empleado.ordenes.recibo', $orden->id) }}" class="btn btn-sm btn-outline-primary">
                                Ver Recibo
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">No hay órdenes registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

