@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <div class="card shadow-lg border-0 rounded-4 p-5 bg-light">
        <h2 class="text-center text-primary mb-4">
            <i class="fas fa-receipt me-2"></i> Detalle de Compra #{{ $compra->id }}
        </h2>

        <!-- Información general -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="bg-white border-start border-4 border-primary shadow-sm rounded-3 p-3">
                    <p class="mb-1"><strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}</p>
                    <p class="mb-1"><strong>Almacén:</strong> {{ $compra->almacen->nombre }}</p>
                    <p class="mb-1"><strong>Fecha:</strong> {{ $compra->fecha->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Total:</strong> Bs {{ number_format($compra->total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="mb-4">
            <h5 class="text-secondary mb-3"><i class="fas fa-box-open me-2"></i>Productos comprados:</h5>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>ID Producto</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario (Bs)</th>
                            <th>Subtotal (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compra->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->id }}</td>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td>{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botón de volver -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('empleado.compras.index') }}" class="btn btn-outline-primary px-4">
                <i class="fas fa-arrow-left me-2"></i> Volver a listado de compras
            </a>
        </div>
    </div>
</div>
@endsection


