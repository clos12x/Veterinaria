@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-paw me-2"></i>Registrar Tipo de Mascota</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('empleado.tipoMascota.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Ver Tipos
                </a>
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-home me-1"></i> Volver al Panel
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('empleado.tipoMascota.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">🐾 Nombre del Tipo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ej: Canino, Felino, etc.">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
