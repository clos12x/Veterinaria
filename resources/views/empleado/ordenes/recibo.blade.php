@extends('layouts.app')

@section('content')
<style>
    .recibo-wrapper {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', sans-serif;
    }

    .recibo-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        color: #0d6efd;
        margin-bottom: 30px;
    }

    .recibo-section {
        margin-bottom: 20px;
    }

    .recibo-section p {
        margin: 4px 0;
        font-size: 1rem;
        color: #333;
    }

    .recibo-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
    }

    .recibo-table th, .recibo-table td {
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: center;
    }

    .recibo-table th {
        background-color: #f1f3f5;
        font-weight: 600;
    }

    .recibo-total {
        font-size: 1.2rem;
        text-align: right;
        margin-top: 15px;
        font-weight: bold;
    }

    .recibo-actions {
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-volver {
        background-color: #6c757d;
        color: white;
    }

    .btn-volver:hover {
        background-color: #5a6268;
    }

    .btn-pdf {
        background-color: #dc3545;
        color: white;
    }

    .btn-pdf:hover {
        background-color: #bb2d3b;
    }
</style>

<div class="recibo-wrapper">
    <div class="recibo-title">🧾 Recibo de Venta </div>

    <div class="recibo-section">
        <p><strong>Cliente:</strong> {{ $orden->venta->cliente->name ?? 'No disponible' }}</p>
        <p><strong>Fecha de compra:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>

        @php $direccion = $orden->direccion; @endphp

        @if($orden->tipo_entrega === 'delivery')
            <p><strong>Tipo de entrega:</strong> 🚚 Delivery</p>
            <p><strong>Dirección:</strong>
                {{ $direccion->direccion ?? 'No definida' }},
                {{ $direccion->zona ?? '-' }} -
                {{ $direccion->ciudad ?? '-' }}<br>
                🔑 {{ $direccion->referencia ?? 'Sin referencia' }}<br>
                📞 {{ $direccion->telefono ?? 'Sin teléfono' }}
            </p>
        @else
            <p><strong>Tipo de entrega:</strong> 🏥 Retiro en Veterinaria</p>
        @endif
    </div>

    <table class="recibo-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                    <td>Bs {{ number_format($detalle->precio_unitario ?? 0, 2) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs {{ number_format(($detalle->precio_unitario ?? 0) * $detalle->cantidad, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="recibo-total">
        Total: Bs {{ number_format($orden->venta->total, 2) }}
    </div>

    <div class="recibo-actions">
        <a href="{{ route('empleado.ordenes.index') }}" class="btn-custom btn-volver">← Volver a Órdenes</a>
        <a href="{{ route('empleado.ordenes.recibo.pdf', $orden->id) }}" class="btn-custom btn-pdf">📥 Descargar PDF</a>
    </div>
</div>
@endsection
