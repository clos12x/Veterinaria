@extends('layouts.app')

@section('content')
<div class="container py-5 font-[Poppins]">
    <h2 class="text-center text-primary fw-bold mb-5">
        <i class="fas fa-boxes me-2"></i> Stock por Almacén
    </h2>

    <!-- Botón Volver al Panel -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('empleado.panel') }}" class="btn btn-outline-dark px-4 rounded-pill shadow-sm">
            <i class="fas fa-home me-1"></i> Volver al Panel
        </a>
    </div>

    @foreach($stockPorAlmacen as $data)
        <div class="card border-0 shadow-lg rounded-4 mb-5">
            <div class="card-header bg-gradient bg-dark text-white rounded-top-4">
                <h5 class="mb-0"><i class="fas fa-warehouse me-2"></i>{{ $data['almacen']->nombre }}</h5>
            </div>

            <div class="card-body bg-light">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0 text-center bg-white shadow-sm">
                        <thead class="table-primary">
                            <tr>
                                <th class="fw-semibold">📦 Producto</th>
                                <th class="fw-semibold">📊 Nivel de Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['productos'] as $producto)
                                @php
                                    $stock = $producto->stock;
                                    $badgeClass = 'bg-secondary';
                                    $badgeText = 'Medio';

                                    if ($stock == 0) {
                                        $badgeClass = 'bg-dark text-white';
                                        $badgeText = 'Sin Stock';
                                    } elseif ($stock < 5) {
                                        $badgeClass = 'bg-danger';
                                        $badgeText = 'Bajo';
                                    } elseif ($stock >= 5 && $stock < 10) {
                                        $badgeClass = 'bg-warning text-dark';
                                        $badgeText = 'Medio';
                                    } elseif ($stock >= 10) {
                                        $badgeClass = 'bg-success';
                                        $badgeText = 'Óptimo';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }} px-3 py-2 fs-6">
                                            {{ $stock }}
                                            <small class="d-block">{{ $badgeText }}</small>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-muted">No hay productos en este almacén.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
