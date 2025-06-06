@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 🔙 Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
            ← Volver al panel
        </a>
    </div>

    <h2 class="text-center mb-4 fw-bold text-primary">🛒 Carrito de Venta</h2>

    @if(session('success'))
        <div class="alert alert-success text-center shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center shadow-sm">{{ session('error') }}</div>
    @endif

    @if(!empty($carrito))
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center shadow-sm bg-white rounded">
                <thead class="table-primary">
                    <tr class="align-middle">
                        <th>Producto</th>
                        <th>Stock Disponible</th>
                        <th>Precio Unitario (Bs)</th>
                        <th>Cantidad</th>
                        <th>Subtotal (Bs)</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($carrito as $item)
                        @php $subtotal = $item['precio'] * $item['cantidad']; @endphp
                        <tr>
                            <td class="fw-semibold">{{ $item['nombre'] }}</td>
                            <td>
                                <span class="fw-medium" style="color: {{ $item['stock_actual'] == 0 ? 'red' : ($item['stock_actual'] <= 5 ? 'orange' : 'green') }}">
                                    {{ $item['stock_actual'] }} unidades
                                </span>
                            </td>
                            <td class="text-success">Bs {{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('empleado.ventas.carrito.actualizar', $item['id_producto']) }}" class="d-flex justify-content-center align-items-center gap-2">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['stock_actual'] }}" class="form-control text-center" style="width: 80px;">
                            </td>
                            <td class="fw-bold">Bs {{ number_format($subtotal, 2) }}</td>
                            <td>
                                    <button type="submit" class="btn btn-warning btn-sm rounded-pill px-3">
                                        🔄 Actualizar
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('empleado.ventas.carrito.eliminar', $item['id_producto']) }}">
                                    @csrf
                                    <button type="submit" onclick="return confirm('¿Eliminar este producto del carrito?')" class="btn btn-danger btn-sm rounded-pill px-3">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $subtotal; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <h4 class="text-end mt-4 fw-bold">Total: <span class="text-success">Bs {{ number_format($total, 2) }}</span></h4>

        <!-- Confirmar venta -->
        <div class="card shadow-sm border-0 mt-4 rounded-4">
            <div class="card-body text-center">
                <form method="POST" action="{{ route('empleado.ventas.confirmar') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label fw-semibold">👤 Cliente (opcional):</label>
                        <select name="id_cliente" id="id_cliente" class="form-select w-auto mx-auto">
                            <option value="">Sin cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow">
                        💾 Confirmar Venta
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm mt-5">
            No hay productos en el carrito.
        </div>
    @endif

    <!-- ➕ Agregar más productos -->
    <div class="text-center mt-5">
        <a href="{{ route('empleado.ventas.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow">
            ➕ Agregar más productos
        </a>
    </div>
</div>
@endsection

