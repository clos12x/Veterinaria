@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Transferir Productos entre Almacenes</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('empleado.almacenes.stock') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-boxes me-1"></i> Ver Stock
                </a>
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-home me-1"></i> Volver al Panel
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('empleado.almacenes.transferir.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="id_producto" class="form-label fw-semibold">📦 Producto</label>
                    <select name="id_producto" id="id_producto" class="form-select" required>
                        <option value="" disabled selected>Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_almacen_origen" class="form-label fw-semibold">🏢 Almacén Origen</label>
                    <select name="id_almacen_origen" id="id_almacen_origen" class="form-select" required>
                        <option value="" disabled selected>Seleccione almacén de origen</option>
                        @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_almacen_destino" class="form-label fw-semibold">🏬 Almacén Destino</label>
                    <select name="id_almacen_destino" id="id_almacen_destino" class="form-select" required>
                        <option value="" disabled selected>Seleccione almacén destino</option>
                        @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="cantidad" class="form-label fw-semibold">🔢 Cantidad a transferir</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">
                        🚚 Realizar Transferencia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


