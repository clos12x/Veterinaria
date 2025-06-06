@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-paw"></i> Registrar Mascota</h4>
        </div>

        <div class="card-body">

            {{-- ✅ Mensaje visual de éxito o error --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            {{-- ✅ Formulario --}}
            <form method="POST" action="{{ route('empleado.mascota.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">🐶 Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="edad" class="form-label fw-semibold">📆 Edad</label>
                    <input type="text" name="edad" id="edad" class="form-control" placeholder="Ej: 2 años, 3 meses" required>
                </div>

                <div class="mb-3">
                    <label for="raza" class="form-label fw-semibold">🧬 Raza</label>
                    <input type="text" name="raza" id="raza" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="id_cliente" class="form-label fw-semibold">👤 Cliente</label>
                    <select name="id_cliente" id="id_cliente" class="form-select" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="id_tipoMascota" class="form-label fw-semibold">🐾 Tipo de Mascota</label>
                    <select name="id_tipoMascota" id="id_tipoMascota" class="form-select" required>
                        <option value="">Seleccione un tipo</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id_tipoMascota }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('empleado.mascota.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Ver Mascota
                    </a>
                    <button type="submit" class="btn btn-success shadow">
                        <i class="fas fa-save"></i> Guardar Mascota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection