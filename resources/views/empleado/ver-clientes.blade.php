@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary mb-0">
            <i class="fas fa-users me-2"></i>Lista de Clientes
        </h2>
        <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-dark">
            <i class="fas fa-home me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- Buscador -->
    <form method="GET" action="{{ route('empleado.verClientes') }}" class="mb-4 d-flex flex-wrap gap-2">
        <input type="text" name="busqueda" class="form-control" style="max-width: 300px;"
               placeholder="🔍 Buscar por nombre o email" value="{{ request('busqueda') }}">
        <button type="submit" class="btn btn-outline-primary">Buscar</button>
        <a href="{{ route('empleado.verClientes') }}" class="btn btn-outline-secondary">Limpiar</a>
    </form>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>👤 Nombre</th>
                            <th>📧 Email</th>
                            <th>🕒 Registrado</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr class="text-center">
                                <td>{{ $cliente->name }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('empleado.editarCliente', $cliente->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </a>
                                    <form method="POST" action="{{ route('empleado.eliminarCliente', $cliente->id) }}" onsubmit="return confirm('¿Eliminar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt me-1"></i>Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No se encontraron clientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



