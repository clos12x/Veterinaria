@extends('layouts.app')

@section('content')
<!-- CDN de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white fs-4 fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="fas fa-warehouse"></i> Lista de Almacenes</span>
            <div>
                <a href="{{ route('empleado.panel') }}" class="btn btn-outline-light me-2">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
                <a href="{{ route('empleado.almacen.create') }}" class="btn btn-light text-primary fw-bold shadow-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo Almacén
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- ✅ Mensaje de éxito -->
            @if(session('success'))
                <script>
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '{{ session("success") }}',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>
            @endif

            <!-- 🔍 Buscador -->
            <form method="GET" action="{{ route('empleado.almacen.index') }}" class="mb-4 d-flex justify-content-end align-items-center flex-wrap gap-2">
                <input type="text" name="buscar" class="form-control w-auto" placeholder="Buscar almacén..." value="{{ request('buscar') }}">

                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Buscar
                </button>

                @if(request()->filled('buscar'))
                    <a href="{{ route('empleado.almacen.index') }}" class="btn btn-outline-dark">
                        <i class="fas fa-times-circle"></i> Limpiar
                    </a>
                @endif
            </form>

            <!-- 📋 Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>🏷️ Nombre</th>
                            <th>📍 Ubicación</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($almacenes as $almacen)
                            <tr>
                                <td>{{ $almacen->nombre }}</td>
                                <td>{{ $almacen->ubicacion }}</td>
                                <td>
                                    <a href="{{ route('empleado.almacen.edit', $almacen->id) }}" class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>

                                    <form action="{{ route('empleado.almacen.destroy', $almacen->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-button">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted">No hay almacenes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Confirmación de eliminación -->
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

