@extends('layouts.app')

@section('content')
<style>
    .historial-container {
        max-width: 900px;
        margin: auto;
        font-family: 'Segoe UI', sans-serif;
    }

    .historial-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        color: #0d6efd;
        margin-bottom: 30px;
    }

    .compra-card {
        border-left: 6px solid #0d6efd;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        transition: 0.3s ease;
        background-color: #fff;
    }

    .compra-card:hover {
        transform: scale(1.01);
    }

    .compra-header {
        background: #f1f3f5;
        padding: 15px 20px;
        border-radius: 10px 10px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .compra-header strong {
        color: #212529;
    }

    .compra-body {
        padding: 20px;
    }

    .producto-item {
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
    }

    .producto-item:last-child {
        border-bottom: none;
    }

    .total-compra {
        text-align: right;
        margin-top: 20px;
        font-weight: bold;
        color: #198754;
        font-size: 1.1rem;
    }

    .no-compras {
        text-align: center;
        font-size: 1.2rem;
        color: #6c757d;
        padding: 60px 0;
    }
</style>

<div class="historial-container">
    <h2 class="historial-title">🗂️ Historial de Compras</h2>

    @if($ventas->isEmpty())
        <div class="no-compras">Aún no has realizado ninguna compra.</div>
    @else
        @foreach($ventas as $venta)
            <div class="compra-card">
                <div class="compra-header">
                    <strong>Compra #{{ $venta->id }}</strong>
                    <span><i class="fas fa-calendar-alt me-1 text-primary"></i>{{ $venta->fecha->format('d/m/Y H:i') }}</span>
                </div>
                <div class="compra-body">
                    @foreach($venta->detalles as $detalle)
                        <div class="producto-item">
                            <span>{{ $detalle->producto->nombre ?? 'Producto eliminado' }} x {{ $detalle->cantidad }}</span>
                            <span>Bs {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</span>
                        </div>
                    @endforeach

                    <div class="total-compra">
                        Total: Bs {{ number_format($venta->total, 2) }}
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
