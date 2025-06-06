@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Cliente</h5>
            <a href="{{ route('empleado.verClientes') }}" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('empleado.actualizarCliente', $cliente->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">👤 Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $cliente->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">📧 Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $cliente->email }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

