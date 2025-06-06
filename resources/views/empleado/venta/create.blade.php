@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 🔙 Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
            ← Volver al panel
        </a>
    </div>

    <h2 class="text-center mb-4">🛒 <strong>Venta por Almacén</strong></h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- Selector de Almacén -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <form method="GET" action="{{ route('empleado.ventas.create') }}" class="d-flex justify-content-center align-items-center flex-wrap gap-3">
                <label class="fw-semibold mb-0">Seleccionar Almacén:</label>
                <select name="id_almacen" onchange="this.form.submit()" class="form-select w-auto rounded-pill">
                    <option value="">-- Elija un almacén --</option>
                    @foreach($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ $idAlmacen == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if($idAlmacen && count($productos))
        <div class="mb-3">
            <h4>📦 Productos en: <strong>{{ $productos->first()->nombre_almacen }}</strong></h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center shadow-sm rounded bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Cantidad</th>
                        <th>Agregar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen" width="80" height="80" class="rounded shadow-sm" style="object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/no-imagen.png') }}" alt="Sin imagen" width="80" height="80" class="rounded shadow-sm" style="object-fit: cover;">
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $producto->nombre }}</td>
                            <td class="text-success fw-bold">Bs {{ number_format($producto->precio, 2) }}</td>
                            <td style="color: {{ $producto->stock <= 5 ? 'orange' : 'green' }};">
                                {{ $producto->stock }}
                            </td>
                            <td>
                                <form method="POST" action="{{ route('empleado.ventas.agregarProducto') }}" class="d-flex justify-content-center align-items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                                    <input type="hidden" name="id_almacen" value="{{ $producto->id_almacen }}">
                                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="form-control text-center" style="width: 70px;">
                            </td>
                            <td>
                                    <button type="submit" class="btn btn-primary rounded-pill">
                                        ➕ Agregar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('empleado.ventas.carrito') }}" class="btn btn-success px-4 py-2 rounded-pill shadow">
                🛒 Ver Carrito
            </a>
        </div>
    @elseif($idAlmacen)
        <div class="alert alert-warning text-center mt-4">
            No hay productos disponibles en este almacén.
        </div>
    @endif
</div>
@endsection
