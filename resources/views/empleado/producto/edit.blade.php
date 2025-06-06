@extends('layouts.app')

@section('content')
<div class="container pt-0 d-flex justify-content-center">
    <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 980px;">
        <div class="card-header bg-warning text-dark text-center fs-5 fw-semibold rounded-top-4">
            ✏️ Editar Producto
        </div>

        <div class="card-body px-4 pt-3 pb-5">

            {{-- Mostrar errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Revisa los errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('empleado.productos.update', $producto->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">📦 Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $producto->nombre) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">📝 Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">💰 Precio (Bs)</label>
                    <input type="number" name="precio" step="0.01" class="form-control" required value="{{ old('precio', $producto->precio) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">🏷️ Categoría</label>
                    <select name="id_categoria" class="form-select" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}" {{ $producto->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">🖼 Imagen Actual</label><br>
                    @if($producto->imagen && file_exists(public_path('storage/productos/' . $producto->imagen)))
                        <img src="{{ asset('storage/productos/' . $producto->imagen) }}" width="150" class="rounded shadow-sm mb-2">
                    @else
                        <img src="{{ asset('storage/productos/default.png') }}" width="150" class="rounded shadow-sm mb-2">
                    @endif
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">📤 Cambiar Imagen</label>
                    <input type="file" name="imagen" accept="image/*" class="form-control">
                </div>

                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        💾 Actualizar Producto
                    </button>

                    <a href="{{ route('empleado.productos.index') }}" class="btn btn-secondary px-4 shadow-sm">
                        ↩️ Ver Productos
                    </a>

                    <a href="{{ route('empleado.index') }}" class="btn btn-outline-dark px-4 shadow-sm">
                        🏠 Volver al Panel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

