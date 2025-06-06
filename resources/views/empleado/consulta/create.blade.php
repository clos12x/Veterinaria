@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">
        <div class="card-header bg-gradient bg-info text-white rounded-3 mb-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-notes-medical me-2"></i> Registrar Consulta Médica
            </h4>
            <a href="{{ route('empleado.panel') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-1"></i> Volver al Panel
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('empleado.consulta.store') }}">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="id_mascota" class="form-label fw-semibold">🐾 Mascota</label>
                    <select name="id_mascota" id="id_mascota" class="form-select" required>
                        <option value="">Seleccionar mascota</option>
                        @foreach($mascotas as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }} (Cliente: {{ $m->cliente->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="id_veterinario" class="form-label fw-semibold">👨‍⚕️ Veterinario</label>
                    <select name="id_veterinario" id="id_veterinario" class="form-select" required>
                        <option value="">Seleccionar veterinario</option>
                        @foreach($veterinarios as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="fecha" class="form-label fw-semibold">📅 Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label fw-semibold">📋 Motivo / Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Describa el motivo de la consulta..." required></textarea>
                </div>
            </div>

            <div class="mt-4">
                <p class="fs-5"><strong>💰 Precio de consulta:</strong> <span class="badge bg-success">20 Bs</span></p>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-4 shadow">
                    <i class="fas fa-save me-2"></i>Registrar Consulta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

