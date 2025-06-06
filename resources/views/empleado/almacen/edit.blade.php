@extends('layouts.app')

@section('content')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-warning text-dark fs-4 fw-semibold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-pen-to-square"></i> Editar Almacén</span>
                    <!-- Botón volver arriba -->
                    <a href="{{ route('empleado.panel') }}" class="btn btn-outline-dark btn-sm shadow-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('empleado.almacen.update', $almacen->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre del Almacén <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" value="{{ $almacen->nombre }}" class="form-control rounded-3 shadow-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ubicación</label>
                            <input type="text" name="ubicacion" value="{{ $almacen->ubicacion }}" class="form-control rounded-3 shadow-sm">
                        </div>

                        <button type="submit" class="btn btn-warning w-100 shadow mb-3">
                            <i class="fas fa-save"></i> Actualizar Almacén
                        </button>

                        <!-- Botón volver abajo -->
                        <a href="{{ route('empleado.panel') }}" class="btn btn-outline-secondary w-100 shadow">
                            <i class="fas fa-arrow-left"></i> Volver al Panel del Empleado
                        </a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Alerta y redirección automática al index -->
@if(session('success'))
<script>
    Swal.fire({
        title: '¡Actualizado!',
        text: '{{ session("success") }}',
        icon: 'success',
        confirmButtonText: 'Ver almacenes',
        timer: 2000,
        timerProgressBar: true
    }).then(() => {
        window.location.href = "{{ route('empleado.almacen.index') }}";
    });
</script>
@endif
@endsection