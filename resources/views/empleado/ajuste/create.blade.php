@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-success text-white d-flex align-items-center justify-content-between flex-wrap">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="fas fa-paw me-2"></i> Registrar Ajustes de Stock
    </h4>

    <div class="d-flex gap-2">
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-light btn-sm">
            <i class="fas fa-home me-1"></i> Panel
        </a>
        <a href="{{ route('empleado.ajustes.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fas fa-sliders-h me-1"></i> Ver Ajustes
        </a>
    </div>
</div>

        <div class="card-body">

            {{-- Mensajes de éxito/error --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('empleado.ajustes.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">📦 Producto</label>
                    <select name="id_producto" class="form-select" required>
                        <option value="">-- Selecciona un producto --</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">🏬 Almacén</label>
                    <select name="id_almacen" class="form-select" required>
                        <option value="">-- Selecciona un almacén --</option>
                        @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">🔁 Tipo de Ajuste</label>
                    <select name="tipo" class="form-select" required>
                        <option value="">-- Selecciona el tipo --</option>
                        <option value="entrada">Entrada</option>
                        <option value="salida">Salida</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">🔢 Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" required min="1" placeholder="Ej. 10">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">📝 Glosa</label>
                    <input type="text" name="glosa" class="form-control" required placeholder="Motivo del ajuste">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">📅 Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Registrar Ajuste
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection