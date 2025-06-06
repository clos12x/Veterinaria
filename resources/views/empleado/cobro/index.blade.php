@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-money-bill-wave"></i> Consultas por Cobrar</h3>
        </div>

        <div class="card-body bg-light">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle text-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>📅 Fecha</th>
                            <th>🐾 Mascota</th>
                            <th>👨‍⚕️ Veterinario</th>
                            <th>💰 Total a Pagar</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            @php
                                $totalServicios = $consulta->servicios->sum('precio');
                                $totalFinal = $consulta->precio_consulta + $totalServicios;
                            @endphp
                            <tr class="text-center">
                                <td>{{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}</td>
                                <td class="fw-semibold text-primary">{{ $consulta->mascota->nombre }}</td>
                                <td>{{ $consulta->veterinario->name }}</td>
                                <td><span class="badge bg-success fs-6">Bs {{ number_format($totalFinal, 2) }}</span></td>
                                <td>
                                    <form method="POST" action="{{ route('empleado.cobros.cobrar', $consulta->id_consulta) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success shadow" onclick="return confirm('¿Confirmar cobro?')">
                                            <i class="fas fa-cash-register"></i> Cobrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle fa-lg"></i> No hay consultas pendientes de cobro.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Botón Volver al panel del empleado -->
            <div class="mt-4 text-end">
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary shadow">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection