@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Agregar Stock a un Producto</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('empleado.almacenes.stock') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Ver Stock
                </a>
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-home me-1"></i> Volver al Panel
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('empleado.stock.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="id_almacen" class="form-label fw-semibold">🗃️ Almacén</label>
                    <select name="id_almacen" id="id_almacen" class="form-select" required>
                        <option value="" disabled selected>Seleccione un almacén</option>
                        @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                        @endforeach
                    </select>
                </div>

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
                    <label for="cantidad" class="form-label fw-semibold">🔢 Cantidad a Agregar</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Guardar Stock
                </button>
            </form>
        </div>
    </div>
</div>
@endsection


