@extends('layouts.app')

@section('content')
<style>
    .recibo-container {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .recibo-container h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 25px;
        text-align: center;
    }

    .recibo-container table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .recibo-container th,
    .recibo-container td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .recibo-container th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .total-text {
        font-size: 1.2rem;
        font-weight: bold;
        color: #212529;
        margin-bottom: 20px;
    }

    .btn-imprimir {
        display: inline-block;
        background: #198754;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.3s;
        margin-right: 10px;
    }

    .btn-imprimir:hover {
        background: #157347;
    }

    .btn-volver {
        background: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.3s;
    }

    .btn-volver:hover {
        background: #0b5ed7;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .recibo-container, .recibo-container * {
            visibility: visible;
        }

        .recibo-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
        }

        .btn-imprimir, .btn-volver {
            display: none !important;
        }
    }
</style>

<div class="recibo-container" id="recibo">
    <h2>🧾 Recibo de Compra</h2>

    <div class="total-text">
        <strong>Total:</strong> Bs {{ number_format($venta->total, 2) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario (Bs)</th>
                <th>Subtotal (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Botones -->
    <div class="text-center mt-3">
        <button onclick="window.print()" class="btn-imprimir">
            🖨️ Imprimir Recibo
        </button>
        <a href="{{ route('tienda.index') }}" class="btn-volver">
            ⬅️ Volver a la tienda
        </a>
    </div>
</div>
@endsection

