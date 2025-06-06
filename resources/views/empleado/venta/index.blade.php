@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 🔙 Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
            ← Volver al panel
        </a>
    </div>

    <h2 class="text-center mb-4">📋 <strong>Ventas Realizadas</strong></h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total (Bs)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->fecha }}</td>
                        <td>{{ $venta->cliente->name ?? 'Sin cliente' }}</td>
                        <td class="text-success fw-bold">Bs {{ number_format($venta->total, 2) }}</td>
                        <td>
                            <a href="{{ route('empleado.ventas.recibo', $venta->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                🧾 Ticket
                            </a>
                            <a href="{{ route('empleado.devoluciones.create', ['id_venta' => $venta->id]) }}" class="btn btn-sm btn-outline-danger rounded-pill ms-2">
                                ↩️ Devolver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ➕ Nueva venta -->
    <div class="text-center mt-4">
        <a href="{{ route('empleado.ventas.create') }}" class="btn btn-success px-4 py-2 rounded-pill shadow">
            ➕ Nueva Venta
        </a>
    </div>
</div>
@endsection
