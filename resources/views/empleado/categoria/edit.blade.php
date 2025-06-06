@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-warning text-white fs-4 fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="fas fa-edit"></i> Editar Categoría</span>
            <a href="{{ route('empleado.categorias.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left"></i> Volver a la Lista
            </a>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('empleado.categorias.update', $categoria->id_categoria) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nombre" class="form-label fw-semibold">Nombre de la Categoría</label>
                    <input type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }}" class="form-control @error('nombre') is-invalid @enderror" required>
                    @error('nombre')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning text-white shadow d-flex align-items-center gap-2">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
