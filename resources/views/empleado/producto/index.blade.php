@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">

        <!-- Título y botón de crear -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold mb-0">
                <i class="fas fa-boxes-stacked me-2"></i> Productos Registrados
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('empleado.panel') }}" class="btn btn-outline-dark rounded-pill">
                    <i class="fas fa-home me-1"></i> Volver al Panel
                </a>
                <a href="{{ route('empleado.productos.create') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-plus-circle me-1"></i> Nuevo Producto
                </a>
            </div>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabla de productos -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center bg-white shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio (Bs)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" width="70" class="rounded shadow-sm" alt="img">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td class="text-success fw-semibold">{{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <a href="{{ route('empleado.productos.edit', $producto->id) }}"
                                   class="btn btn-outline-warning btn-sm rounded-pill mb-1">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>

                                <form action="{{ route('empleado.productos.destroy', $producto->id) }}" method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este producto?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                        <i class="fas fa-trash-alt me-1"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


