@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<div class="container py-5" style="max-width: 1000px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4 flex-wrap gap-2">
            <h4 class="mb-0 d-flex align-items-center">
                <i class="fas fa-truck me-2"></i> Lista de Proveedores
            </h4>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('empleado.index') }}" class="btn btn-outline-light fw-semibold shadow-sm">
                    <i class="fas fa-home me-1"></i> Volver al Panel
                </a>
                <a href="{{ route('empleado.proveedores.create') }}" class="btn btn-light fw-semibold shadow-sm">
                    <i class="fas fa-plus-circle me-1"></i> Nuevo Proveedor
                </a>
            </div>
        </div>

        <div class="card-body bg-light">
            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success text-center shadow-sm fw-semibold">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Tabla de proveedores --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center bg-white shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>👤 Nombre</th>
                            <th>📞 Teléfono</th>
                            <th>📧 Email</th>
                            <th>📍 Dirección</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $p)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $p->nombre }}</td>
                                <td>{{ $p->telefono }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->direccion }}</td>
                                <td class="d-flex flex-column gap-1 align-items-center">
                                    <a href="{{ route('empleado.proveedores.edit', $p->id) }}" class="btn btn-warning btn-sm w-100 shadow-sm">
                                        ✏️ Editar
                                    </a>
                                    <form method="POST" action="{{ route('empleado.proveedores.destroy', $p->id) }}" class="w-100" onsubmit="return confirm('¿Eliminar este proveedor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100 shadow-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- FontAwesome --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>
@endsection

