@extends('layouts.app')

@section('content')
<style>
    .direccion-wrapper {
        max-width: 700px;
        margin: auto;
        font-family: 'Segoe UI', sans-serif;
    }

    .direccion-wrapper h2 {
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        color: #0d6efd;
        margin-bottom: 30px;
    }

    .btn-header-panel {
        font-size: 0.9rem;
        padding: 6px 16px;
        border-radius: 30px;
        border: 1px solid #0d6efd;
        color: #0d6efd;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .btn-header-panel:hover {
        background-color: #0d6efd;
        color: #fff;
    }
</style>

<div class="container py-4 direccion-wrapper">
    <h2>📍 Mi Dirección de Envío</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($direccion)
        <!-- Formulario de actualización -->
        <form method="POST" action="{{ route('cliente.direccion.update', $direccion->id) }}" class="card p-4 shadow-sm mb-4">
            @csrf
            @method('PUT')

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-primary mb-0">✏️ Editar dirección registrada</h5>
                <a href="{{ route('cliente.dashboard') }}" class="btn-header-panel">
                    ← Inicio
                </a>
            </div>

            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" required value="{{ old('direccion', $direccion->direccion) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Zona / Barrio</label>
                <input type="text" name="zona" class="form-control" value="{{ old('zona', $direccion->zona) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="ciudad" class="form-control" required value="{{ old('ciudad', $direccion->ciudad) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Referencia</label>
                <input type="text" name="referencia" class="form-control" value="{{ old('referencia', $direccion->referencia) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required value="{{ old('telefono', $direccion->telefono) }}">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success px-5">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>

        <!-- Formulario de eliminación -->
        <form method="POST" action="{{ route('cliente.direccion.destroy', $direccion->id) }}" onsubmit="return confirm('¿Eliminar esta dirección?')" class="text-center mb-4">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger px-5">
                🗑️ Eliminar Dirección
            </button>
        </form>
    @else
        <!-- Formulario de creación -->
        <form method="POST" action="{{ route('cliente.direccion.store') }}" class="card p-4 shadow-sm">
            @csrf

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-success mb-0">➕ Registrar nueva dirección</h5>
                <a href="{{ route('cliente.dashboard') }}" class="btn-header-panel">
                    ← Panel
                </a>
            </div>

            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Zona / Barrio</label>
                <input type="text" name="zona" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="ciudad" class="form-control" required value="Santa Cruz">
            </div>

            <div class="mb-3">
                <label class="form-label">Referencia</label>
                <input type="text" name="referencia" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">
                    💾 Registrar Dirección
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
