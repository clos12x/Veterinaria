@extends('layouts.app')

@section('content')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 2000,
                timerProgressBar: true
            });
        });
    </script>
@endif

<div class="container mt-5">
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-folder-open me-2"></i>Gestión de Categorías
            </h4>
            <div>
                <a href="{{ route('empleado.panel') }}" class="btn btn-outline-light me-2">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
                <a href="{{ route('empleado.categorias.create') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                    <i class="fas fa-plus-circle"></i> Nueva Categoría
                </a>
            </div>
        </div>

        <div class="card-body px-4 py-4">
            <!-- 🔍 Buscador -->
            <form method="GET" action="{{ route('empleado.categorias.index') }}" class="mb-4 d-flex flex-wrap justify-content-end gap-2">
                <input type="text" name="buscar" class="form-control w-auto" placeholder="Buscar categoría..." value="{{ request('buscar') }}">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if(request()->filled('buscar'))
                    <a href="{{ route('empleado.categorias.index') }}" class="btn btn-outline-dark">
                        <i class="fas fa-times-circle"></i> Limpiar
                    </a>
                @endif
            </form>

            <!-- 📋 Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="fas fa-tag text-muted me-1"></i>Nombre</th>
                            <th><i class="fas fa-tools text-muted me-1"></i>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td class="text-start ps-4">{{ $categoria->nombre }}</td>
                                <td>
                                    <a href="{{ route('empleado.categorias.edit', $categoria->id_categoria) }}" class="btn btn-warning btn-sm me-2 shadow-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('empleado.categorias.destroy', $categoria->id_categoria) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar esta categoría?')" class="btn btn-danger btn-sm shadow-sm">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-muted py-4">
                                    <i class="fas fa-info-circle me-1"></i> No se encontraron categorías registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection