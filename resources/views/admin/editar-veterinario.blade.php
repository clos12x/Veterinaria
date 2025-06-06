@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 700px; font-family: 'Poppins', sans-serif;">

    {{-- TÍTULO --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-gradient display-6">
            🩺 Editar Veterinario
        </h2>
        <p class="text-muted">Modifica la información del veterinario seleccionado</p>
    </div>

    {{-- BOTÓN VOLVER --}}
    <div class="mb-4 text-center">
        <a href="{{ route('admin.veterinarios.index') }}" class="btn btn-outline-secondary px-4 py-2">
            🔙 Volver a la Lista de Veterinarios
        </a>
    </div>

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <div class="card shadow border-0 rounded-4 animate-fade-in-down">
        <div class="card-body bg-light p-4">
            <form method="POST" action="{{ route('admin.veterinarios.actualizar', $veterinario->id) }}">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $veterinario->name) }}"
                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Correo --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email', $veterinario->email) }}"
                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botón Guardar --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-gradient btn-lg text-white px-5 py-2 shadow">
                        💾 Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ESTILOS PERSONALIZADOS --}}
<style>
    .text-gradient {
        background: linear-gradient(to right, #ec4899, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-gradient {
        background: linear-gradient(to right, #ec4899, #8b5cf6);
        border: none;
        transition: 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(to right, #f472b6, #7c3aed);
        transform: scale(1.05);
    }

    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.6s ease-out;
    }
</style>
@endsection
