@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-clipboard-list"></i> Consultas Registradas</h4>
        </div>

        <div class="card-body bg-white">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>📅 Fecha</th>
                            <th>🐾 Mascota</th>
                            <th>👤 Cliente</th>
                            <th>👨‍⚕️ Veterinario</th>
                            <th>💼 Empleado</th>
                            <th>📝 Descripción</th>
                            <th>🛠️ Servicios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $consulta->mascota->nombre ?? 'Mascota eliminada' }}</td>
                                <td>{{ $consulta->mascota->cliente->name ?? 'Cliente no disponible' }}</td>
                                <td>{{ $consulta->veterinario->name ?? 'No asignado' }}</td>
                                <td>{{ $consulta->empleado->name ?? 'Empleado no disponible' }}</td>
                                <td class="text-start">{{ $consulta->descripcion }}</td>
                                <td class="text-start">
                                    <ul class="list-unstyled mb-0">
                                        @foreach($consulta->servicios as $servicio)
                                            <li><i class="fas fa-check-circle text-success me-1"></i>{{ $servicio->nombre }} <small class="text-muted">({{ $servicio->tipo->nombre ?? 'Tipo desconocido' }})</small> – Bs {{ number_format($servicio->precio, 2) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle"></i> No hay consultas registradas.
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
