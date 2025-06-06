@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <div class="card shadow-lg border-0 rounded-4 p-5 bg-light">
        <h2 class="text-center text-primary mb-4">
            <i class="fas fa-file-invoice me-2"></i> Registrar Compra
        </h2>

        <form method="POST" action="{{ route('empleado.compras.store') }}">
            @csrf

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="proveedor" class="form-label fw-bold">Proveedor:</label>
                    <select name="id_proveedor" id="proveedor" class="form-select" required>
                        <option value="">Seleccionar proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="id_almacen" class="form-label fw-bold">Almacén:</label>
                    <select name="id_almacen" id="id_almacen" class="form-select" required onchange="mostrarProductosPorAlmacen()">
                        <option value="">Seleccionar almacén</option>
                        @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-5">
                <h5 class="text-secondary mb-3"><i class="fas fa-boxes-stacked me-2"></i>Productos del almacén (ordenados por menor stock):</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center shadow-sm">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario (Bs)</th>
                            </tr>
                        </thead>
                        <tbody id="productos-body"></tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('empleado.panel') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Panel
                </a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save me-2"></i>Registrar Compra
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const productos = @json($productos);
    let index = 0;

    function mostrarProductosPorAlmacen() {
        const idAlmacen = document.getElementById('id_almacen').value;
        const tbody = document.getElementById('productos-body');
        tbody.innerHTML = '';

        if (!idAlmacen) return;

        let productosFiltrados = productos.map(p => {
            let stock = 0;
            const almacenPivot = p.almacenes.find(a => a.pivot.id_almacen == idAlmacen);
            if (almacenPivot) {
                stock = almacenPivot.pivot.stock;
            }
            return {
                id: p.id,
                nombre: p.nombre,
                precio: p.precio,
                stock: stock
            };
        });

        productosFiltrados.sort((a, b) => a.stock - b.stock);

        productosFiltrados.forEach(p => {
            tbody.innerHTML += `
                <tr>
                    <td>
                        ${p.id}
                        <input type="hidden" name="productos[${index}][id_producto]" value="${p.id}">
                    </td>
                    <td>${p.nombre}</td>
                    <td>${p.stock}</td>
                    <td><input type="number" name="productos[${index}][cantidad]" class="form-control" min="0" value="0"></td>
                    <td><input type="number" name="productos[${index}][precio_unitario]" class="form-control" step="0.01"></td>
                </tr>
            `;
            index++;
        });
    }
</script>
@endsection
