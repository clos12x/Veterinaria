@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-undo-alt"></i> Registrar Devolución de Productos</h4>
            <a href="{{ route('empleado.panel') }}" class="btn btn-dark btn-sm shadow">
                <i class="fas fa-arrow-left"></i> Volver al Panel
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('empleado.devoluciones.store.multiple') }}">
                @csrf

                <div class="mb-4">
                    <label for="ventaSelect" class="form-label fw-semibold">🧾 Seleccionar Venta</label>
                    <select name="id_venta" id="ventaSelect" class="form-select" required>
                        <option value="">Seleccione una venta</option>
                        @foreach($ventas as $venta)
                            <option value="{{ $venta->id }}">#{{ $venta->id }} - {{ $venta->fecha }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="tablaProductos" style="display: none;">
                    <h5 class="text-secondary"><i class="fas fa-shopping-cart"></i> Productos de la Venta</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad Comprada</th>
                                    <th>Cantidad Devuelta</th>
                                    <th>Disponible</th>
                                    <th>Cantidad a Devolver</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBody"></tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary shadow">
                            <i class="fas fa-save me-1"></i> Registrar Devoluciones
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-4">
                <a href="{{ route('empleado.devoluciones.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list-ul"></i> Ver devoluciones registradas
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const ventas = @json($ventas);
    const devoluciones = @json(\App\Models\Devolucion::all());
    const ventaSelect = document.getElementById('ventaSelect');
    const tablaProductos = document.getElementById('tablaProductos');
    const tablaBody = document.getElementById('tablaBody');

    ventaSelect.addEventListener('change', function () {
        const ventaId = parseInt(this.value);
        tablaBody.innerHTML = '';
        if (!ventaId) {
            tablaProductos.style.display = 'none';
            return;
        }

        const venta = ventas.find(v => v.id == ventaId);
        if (!venta) return;

        tablaProductos.style.display = 'block';

        venta.detalles.forEach((det, index) => {
            const producto = det.producto;
            const cantidadVendida = det.cantidad;
            const cantidadDevuelta = devoluciones
                .filter(dev => dev.id_venta == ventaId && dev.id_producto == producto.id)
                .reduce((total, d) => total + d.cantidad, 0);
            const cantidadDisponible = cantidadVendida - cantidadDevuelta;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    ${producto.nombre}
                    <input type="hidden" name="productos[${index}][id_producto]" value="${producto.id}">
                </td>
                <td>${cantidadVendida}</td>
                <td>${cantidadDevuelta}</td>
                <td>${cantidadDisponible}</td>
                <td>
                    <input type="number" name="productos[${index}][cantidad]" min="0" max="${cantidadDisponible}" value="0" class="form-control">
                </td>
                <td>
                    <input type="text" name="productos[${index}][motivo]" placeholder="Motivo (opcional)" class="form-control">
                </td>
            `;
            tablaBody.appendChild(tr);
        });
    });
</script>
@endsection
