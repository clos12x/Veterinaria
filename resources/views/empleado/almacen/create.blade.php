@extends('layouts.app')

@section('content')
<!-- CDN de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white fs-4 fw-semibold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-warehouse"></i> Crear Nuevo Almacén</span>
                    <!-- Botón Volver -->
                    <a href="{{ route('empleado.panel') }}" class="btn btn-light text-primary border-0 fw-semibold shadow-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('empleado.almacen.store') }}" id="almacenForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre del Almacén <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3 shadow-sm" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ubicación</label>
                            <input type="text" class="form-control rounded-3 shadow-sm" name="ubicacion">
                        </div>

                        <button type="submit" class="btn btn-success w-100 shadow">
                            <i class="fas fa-save"></i> Guardar Almacén
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ✅ SOLO Muestra mensaje de éxito sin redirigir -->
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

<!-- ✅ También podrías mostrar errores si hay -->
@if(session('error'))
<script>
    Swal.fire({
        title: '¡Error!',
        text: '{{ session("error") }}',
        icon: 'error',
        confirmButtonText: 'OK',
        timer: 2000,
        timerProgressBar: true
    });
</script>
@endif
@endsection
