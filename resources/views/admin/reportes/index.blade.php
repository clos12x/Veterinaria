@extends('layouts.app')

@section('content')
<style>
    .gradient-blue {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: #fff;
    }

    .gradient-purple {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff;
    }

    .gradient-green {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: #fff;
    }

    .gradient-warning {
        background: linear-gradient(135deg, #f7971e, #ffd200);
        color: #000;
    }

    .gradient-danger {
        background: linear-gradient(135deg, #cb2d3e, #ef473a);
        color: #fff;
    }

    .glass {
        backdrop-filter: blur(6px);
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
</style>

<div class="container py-4 animate__animated animate__fadeIn">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="w-100 text-center fw-bold text-gradient" style="font-size: 2.5rem;">
            📊 <span style="background: linear-gradient(to right, #ff512f, #dd2476); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Panel de Reportes Administrativos</span>
        </h2>
    </div>

    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-info fw-bold">
            <i class="fas fa-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- Filtro de búsqueda -->
    <div class="card glass shadow mb-5 border-0 rounded-4">
        <div class="card-body">
            <h5 class="card-title mb-4 fw-bold">🔍 Filtrar Reportes</h5>
            <form method="GET" action="{{ route('admin.reportes.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Fecha Inicio:</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha Fin:</label>
                    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        🔎 Buscar
                    </button>
                    <a href="{{ route('admin.reportes.index') }}" class="btn btn-secondary w-100 mt-2 fw-bold">
                        ♻️ Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen filtrado -->
    @if(request('fecha_inicio') && request('fecha_fin'))
        <div class="alert gradient-warning text-center rounded-4 shadow-sm">
            <h4 class="fw-bold">📅 Resumen Filtrado</h4>
            <p><strong>Consultas:</strong> Bs {{ number_format($consultasTotal, 2) }}</p>
            <p><strong>Servicios:</strong> Bs {{ number_format($serviciosTotal, 2) }}</p>
            <p><strong>Ventas:</strong> Bs {{ number_format($ventasTotal, 2) }}</p>
            <h5 class="py-2 rounded-3 fw-bold">💰 Total: Bs {{ number_format($totalGeneral, 2) }}</h5>
        </div>
    @endif

    <!-- Botón PDF -->
    <div class="text-center mb-4">
        <a href="{{ route('admin.reportes.descargarPdf') }}" class="btn gradient-danger shadow fw-bold px-4 py-2">
            📄 Descargar Reporte PDF
        </a>
    </div>

    <!-- Resumen Económico -->
    <div class="row g-4">
        @foreach([
            ['Consultas Hoy', $consultasDia, 'gradient-blue'],
            ['Consultas Semana', $consultasSemana, 'gradient-blue'],
            ['Consultas Mes', $consultasMes, 'gradient-blue'],
            ['Consultas Año', $consultasAño, 'gradient-blue'],

            ['Servicios Hoy', $serviciosDia, 'gradient-purple'],
            ['Servicios Semana', $serviciosSemana, 'gradient-purple'],
            ['Servicios Mes', $serviciosMes, 'gradient-purple'],
            ['Servicios Año', $serviciosAño, 'gradient-purple'],

            ['Ventas Hoy', $ventasDia, 'gradient-green'],
            ['Ventas Semana', $ventasSemana, 'gradient-green'],
            ['Ventas Mes', $ventasMes, 'gradient-green'],
            ['Ventas Año', $ventasAño, 'gradient-green'],
        ] as [$titulo, $valor, $clase])
            <div class="col-md-3">
                <div class="p-4 rounded-4 text-center shadow {{ $clase }}">
                    <h5 class="fw-bold">{{ $titulo }}</h5>
                    <p class="fs-4">Bs {{ number_format($valor, 2) }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Total General -->
    <div class="alert gradient-green mt-5 text-center shadow rounded-4 fs-4 fw-bold">
        💸 Total General: Bs {{ number_format($totalGeneral, 2) }}
    </div>

    <!-- Top Productos -->
    <div class="mt-5">
        <h4 class="fw-bold mb-3">🏆 Top 5 Productos Más Vendidos</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad Vendida</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProductos as $item)
                        <tr>
                            <td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                            <td>{{ $item->total_vendidos }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Veterinarios -->
    <div class="mt-5">
        <h4 class="fw-bold mb-3">👨‍⚕️ Top 5 Veterinarios Más Activos</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Veterinario</th>
                        <th>Consultas Realizadas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topVeterinarios as $item)
                        <tr>
                            <td>{{ $item->veterinario->name ?? 'Veterinario eliminado' }}</td>
                            <td>{{ $item->total_consultas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gráfico Chart.js -->
    <div class="mt-5">
        <h4 class="fw-bold">📈 Evolución de Ventas y Consultas ({{ now()->year }})</h4>
        <canvas id="graficoEvolucion" height="120"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoEvolucion').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [
                    {
                        label: 'Ventas (Bs)',
                        data: [
                            @for ($i = 1; $i <= 12; $i++)
                                {{ $ventasMensuales[$i] ?? 0 }},
                            @endfor
                        ],
                        borderColor: 'rgba(13, 110, 253, 1)',
                        backgroundColor: 'rgba(13, 110, 253, 0.3)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Consultas (Bs)',
                        data: [
                            @for ($i = 1; $i <= 12; $i++)
                                {{ $consultasMensuales[$i] ?? 0 }},
                            @endfor
                        ],
                        borderColor: 'rgba(25, 135, 84, 1)',
                        backgroundColor: 'rgba(25, 135, 84, 0.3)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Ingresos Mensuales'
                    }
                }
            }
        });
    </script>
</div>
@endsection
