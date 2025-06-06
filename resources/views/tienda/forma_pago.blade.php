@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('web.carrito.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            ← Volver al carrito
        </a>
    </div>
    @if(!empty($carrito))
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-gradient bg-primary text-white fw-semibold d-flex align-items-center">
            <i class="fas fa-shopping-basket me-2"></i> Productos en tu pedido
        </div>

        <ul class="list-group list-group-flush">
            @php $total = 0; @endphp
            @foreach($carrito as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-box-open text-secondary me-2"></i>
                        <strong>{{ $item['nombre'] }}</strong>
                        <small class="text-muted">× {{ $item['cantidad'] }}</small>
                    </div>
                    <span class="text-success fw-semibold">Bs {{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                </li>
                @php $total += $item['precio'] * $item['cantidad']; @endphp
            @endforeach
        </ul>

        <div class="card-footer bg-light text-end">
            <span class="fs-5 fw-bold text-dark">
                Total a pagar: <span class="text-success">Bs {{ number_format($total, 2) }}</span>
            </span>
        </div>
    </div>
@endif
    <h2 class="text-center mb-4">💳 Registrar Método de Pago</h2>

    <form method="POST" action="{{ route('web.carrito.confirmarCompra') }}" enctype="multipart/form-data" onsubmit="return validarFormularioPago()">
        @csrf

        @if(isset($ventaId))
            <input type="hidden" name="venta_id" value="{{ $ventaId }}">
        @endif

        <!-- Método de Pago -->
        <div class="mb-4">
            <label for="metodo" class="form-label fw-bold">Método de Pago:</label>
            <select name="metodo" id="metodo" class="form-select" required onchange="mostrarCamposPago()">
                <option value="">-- Selecciona uno --</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia / QR</option>
            </select>
        </div>

        <!-- Campos de Tarjeta -->
        <div id="camposTarjeta" style="display: none;">
            <div class="mb-3">
                <label for="nombre_titular" class="form-label">Nombre del Titular:</label>
                <input type="text" name="nombre_titular" id="nombre_titular" class="form-control" placeholder="Ej: Juan Pérez">
            </div>
            <div class="mb-3">
                <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                <input type="text" name="numero_tarjeta" id="numero_tarjeta" class="form-control" maxlength="16" placeholder="1111222233334444">
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                    <input type="text" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" placeholder="MM/AA" maxlength="5" oninput="formatearFechaVencimiento(this)">
                </div>
                <div class="col">
                    <label for="cvv" class="form-label">CVV:</label>
                    <input type="text" name="cvv" id="cvv" class="form-control" maxlength="3" placeholder="123">
                </div>
            </div>
        </div>

        <!-- Campos de Transferencia -->
        <div id="camposTransferencia" style="display: none;">
            <div class="mb-3">
                <label for="referencia" class="form-label">Número de Referencia:</label>
                <input type="text" name="referencia" id="referencia" class="form-control" placeholder="Ej: 9876543210">
            </div>
            <div class="mb-3">
                <label for="comprobante" class="form-label">Adjuntar Comprobante (JPG, PNG, PDF):</label>
                <input type="file" name="comprobante" class="form-control" accept=".jpg,.jpeg,.png,.webp,.pdf">
            </div>
        </div>

        <!-- Botón -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fs-5">Confirmar Compra</button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script>
    function mostrarCamposPago() {
        const metodo = document.getElementById('metodo').value;
        document.getElementById('camposTarjeta').style.display = metodo === 'tarjeta' ? 'block' : 'none';
        document.getElementById('camposTransferencia').style.display = metodo === 'transferencia' ? 'block' : 'none';
    }

    function formatearFechaVencimiento(input) {
        let valor = input.value.replace(/\D/g, '');
        if (valor.length >= 2) {
            let mes = valor.substring(0, 2);
            if (parseInt(mes) > 12) mes = '12';
            valor = mes + (valor.length > 2 ? '/' + valor.substring(2, 4) : '');
        }
        input.value = valor;
    }

    function validarFormularioPago() {
        const metodo = document.getElementById('metodo').value;

        if (!metodo) {
            alert('Selecciona un método de pago.');
            return false;
        }

        if (metodo === 'tarjeta') {
            const numero = document.getElementById('numero_tarjeta').value.trim();
            const cvv = document.getElementById('cvv').value.trim();
            const venc = document.getElementById('fecha_vencimiento').value.trim();

            if (!/^\d{16}$/.test(numero)) {
                alert('Número de tarjeta inválido.');
                return false;
            }
            if (!/^\d{3}$/.test(cvv)) {
                alert('CVV inválido.');
                return false;
            }
            if (!/^\d{2}\/\d{2}$/.test(venc)) {
                alert('Fecha inválida. Usa MM/AA');
                return false;
            }
        }

        if (metodo === 'transferencia') {
            const ref = document.getElementById('referencia').value.trim();
            if (!ref) {
                alert('Debes ingresar la referencia.');
                return false;
            }
        }

        return true;
    }

    window.onload = mostrarCamposPago;
</script>
@endsection





