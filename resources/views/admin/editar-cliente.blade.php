@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 700px; font-family: 'Poppins', sans-serif;">

    {{-- TÍTULO --}}
    <div class="text-center mb-4">
        <h1 class="fw-bold text-gradient display-6">
            ✏️ Editar Cliente
        </h1>
    </div>

    {{-- BOTÓN VOLVER --}}
    <div class="mb-4 text-center">
        <a href="{{ route('admin.verClientes') }}" class="btn btn-outline-dark px-4 py-2">
            🏠 Volver a la Lista de Clientes
        </a>
    </div>

    {{-- FORMULARIO --}}
    <div class="card shadow border-0 rounded-4 animate-fade-in-down">
        <div class="card-body bg-light p-4">
            <form method="POST" action="{{ route('admin.actualizarCliente', $cliente->id) }}">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $cliente->name) }}"
                           required
                           class="form-control form-control-lg @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $cliente->email) }}"
                           required
                           class="form-control form-control-lg @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botón Guardar --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-4 py-2 shadow">
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
        background: linear-gradient(to right, #22c55e, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
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
