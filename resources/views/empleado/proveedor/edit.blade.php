@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<div class="container py-5" style="max-width: 700px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-dark text-center fw-semibold fs-5 rounded-top-4">
            ✏️ Editar Proveedor
        </div>

        <div class="card-body bg-light px-4 py-4">

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Por favor corrige los siguientes errores:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('empleado.proveedores.update', $proveedor->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">👤 Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" class="form-control shadow-sm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">📞 Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" class="form-control shadow-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">📧 Email</label>
                    <input type="email" name="email" value="{{ old('email', $proveedor->email) }}" class="form-control shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">📍 Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" class="form-control shadow-sm">
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        💾 Actualizar
                    </button>

                    <a href="{{ route('empleado.proveedores.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                        ↩️ Volver a la lista
                    </a>

                    <a href="{{ route('empleado.index') }}" class="btn btn-outline-dark px-4 shadow-sm">
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
