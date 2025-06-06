@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 🔙 Botón Volver a la tienda -->
    <div class="mb-4">
        <a href="{{ route('tienda.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            ← Volver a la tienda
        </a>
    </div>

    <h2 class="text-center mb-4">🛒 Carrito de Compras</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @php $total = 0; @endphp

    @if(!empty($carrito))
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center shadow-sm bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrito as $id => $item)
                        @php
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>Bs {{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <form action="{{ route('web.carrito.actualizar', $id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control d-inline-block w-auto">
                                    <button type="submit" class="btn btn-sm btn-primary ms-1">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>
                            </td>
                            <td>Bs {{ number_format($subtotal, 2) }}</td>
                            <td>
                        <form action="{{ route('web.carrito.eliminar', $id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th colspan="2" class="text-start">Bs {{ number_format($total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- 🔄 Formulario según autenticación -->
        @if(Auth::check())
            <form method="POST" action="{{ route('web.carrito.irFormaPago') }}" class="mt-4">
                @csrf

                <div class="card p-4 shadow-sm mb-4">
                    <h5 class="mb-3">📦 Método de Entrega</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">¿Cómo deseas recibir tus productos?</label>
                        <select name="tipo_entrega" id="tipo_entrega" class="form-select" required>
                            <option value="">-- Selecciona --</option>
                            <option value="delivery">🛵 Entrega a domicilio</option>
                            <option value="retiro">🏥 Retiro en veterinaria</option>
                        </select>
                    </div>

                    <!-- Direcciones solo si se elige delivery -->
                    <div id="direccion_envio" class="mb-3" style="display: none;">
                        <label class="form-label fw-semibold">Selecciona tu dirección registrada:</label>
                        <select name="direccion_envio_id" class="form-select">
                            @foreach(auth()->user()->direccionesEnvio as $direccion)
                                <option value="{{ $direccion->id }}">
                                    {{ $direccion->direccion }} - {{ $direccion->zona }} ({{ $direccion->telefono }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            ¿No tienes dirección registrada?
                            <a href="{{ route('cliente.direccion.index') }}">Agregar dirección</a>
                        </small>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-5 py-2 rounded-pill fs-5">
                        Continuar al Pago
                    </button>
                </div>
            </form>
        @else
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary px-5 py-2 rounded-pill fs-5">
                    Iniciar sesion para la compra 🔒
                </a>
            </div>
        @endif

    @else
        <div class="alert alert-info text-center">
            Tu carrito está vacío.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoEntrega = document.getElementById('tipo_entrega');
        const direccionDiv = document.getElementById('direccion_envio');

        tipoEntrega.addEventListener('change', function () {
            direccionDiv.style.display = this.value === 'delivery' ? 'block' : 'none';
        });
    });
</script>
@endsection





