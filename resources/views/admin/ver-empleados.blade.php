@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">

    {{-- ENCABEZADO --}}
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-gradient">👷 Lista de Empleados</h2>
        <p class="text-muted">Gestión eficiente del personal</p>
    </div>

    {{-- BUSCADOR --}}
    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.verEmpleados') }}" class="row gy-2 gx-3 align-items-center justify-content-center">
                <div class="col-md-5">
                    <input type="text" name="busqueda" class="form-control form-control-lg"
                           placeholder="🔍 Buscar por nombre o email"
                           value="{{ request('busqueda') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.verEmpleados') }}" class="btn btn-danger btn-lg">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA DE EMPLEADOS --}}
    <div class="card shadow border-0 rounded-4 animate-fade-in-down">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-success text-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $emp)
                        <tr>
                            <td class="fw-semibold">{{ $emp->name }}</td>
                            <td>{{ $emp->email }}</td>
                            <td>{{ $emp->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.editarEmpleado', $emp->id) }}"
                                       class="btn btn-warning btn-sm">
                                       ✏️ Editar
                                    </a>
                                    <form action="{{ route('admin.eliminarEmpleado', $emp->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar este empleado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4 fst-italic">
                                No se encontraron empleados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ESTILOS PERSONALIZADOS --}}
<style>
    .text-gradient {
        background: linear-gradient(to right, #059669, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.5s ease-out;
    }
</style>
@endsection
