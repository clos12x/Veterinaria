@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<style>
    .form-card {
        background: #fefefe;
        border-radius: 1.5rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .card-header {
        background: linear-gradient(90deg, #007bff, #00c6ff);
        font-size: 1.25rem;
        font-weight: 600;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
    }
</style>

<div class="container py-5" style="max-width: 850px;">
    <div class="card form-card border-0">
        <div class="card-header text-white text-center">
            <i class="fas fa-box-open me-2"></i> Registrar Nuevo Producto
        </div>

        <div class="card-body p-4">
            {{-- Mostrar errores --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <strong><i class="fas fa-exclamation-circle me-2"></i> Revisa los errores del formulario:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('empleado.productos.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">📦 Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">📝 Descripción</label>
                    <textarea name="descripcion" rows="3" class="form-control shadow-sm" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">💰 Precio (Bs)</label>
                        <input type="number" name="precio" step="0.01" class="form-control shadow-sm" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">🏷️ Categoría</label>
                        <select name="id_categoria" class="form-select shadow-sm" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">🖼 Imagen (opcional)</label>
                    <input type="file" name="imagen" accept="image/*" class="form-control shadow-sm">
                </div>

                {{-- Botones --}}
                <div class="text-center mt-4 d-flex flex-wrap justify-content-center gap-3">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        💾 Guardar Producto
                    </button>

                    <a href="{{ route('empleado.productos.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                        📋 Ver Productos
                    </a>

                    <a href="{{ route('empleado.panel') }}" class="btn btn-outline-dark px-4 shadow-sm">
                        🏠 Volver al Panel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- FontAwesome --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>
@endsection
