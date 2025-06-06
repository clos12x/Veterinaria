@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <div class="card shadow-lg border-0 rounded-4 bg-light">
        <!-- Encabezado -->
        <div class="card-header bg-gradient bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle me-2"></i> Crear Nueva Categoría
            </h4>
            <a href="{{ route('empleado.categorias.index') }}" class="btn btn-outline-light">
                <i class="fas fa-list me-1"></i> Volver a la Lista
            </a>
        </div>

        <!-- Formulario -->
        <div class="card-body p-4">
            <form method="POST" action="{{ route('empleado.categorias.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="nombre" class="form-label fw-semibold">📛 Nombre de la Categoría</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control shadow-sm @error('nombre') is-invalid @enderror"
                        placeholder="Ej: Medicamentos, Alimentos, Accesorios..." required>
                    @error('nombre')
                        <div class="invalid-feedback d-block mt-1">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex flex-wrap justify-content-end gap-3">
                    <a href="{{ route('empleado.index') }}" class="btn btn-secondary d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-times-circle"></i> Cancelar
                    </a>

                    <a href="{{ route('empleado.panel') }}" class="btn btn-outline-dark d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-home"></i> Volver al Panel
                    </a>

                    <button type="submit" class="btn btn-success d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

