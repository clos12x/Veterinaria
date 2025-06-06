@extends('layouts.app')

@section('styles')
<style>
/* SOLO se aplica cuando imprimas */
@media print {
    body * {
        visibility: hidden;
    }

    .print-area, .print-area * {
        visibility: visible;
    }

    .print-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding: 0;
        font-size: 14px;
        background: white;
    }

    button, a {
        display: none !important;
    }
}
</style>
@endsection

@section('content')
<div class="container py-4 print-area">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Recibo de Consulta</h4>
        </div>

        <div class="card-body bg-white">
            <div class="mb-4">
                <h5 class="text-secondary">🕓 Fechas</h5>
                <p><strong>Consulta:</strong> {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}</p>
                <p><strong>Cobro:</strong> {{ \Carbon\Carbon::parse($consulta->fecha_cobro)->format('d/m/Y') }}</p>
            </div>

            <hr>

            <div class="mb-4">
                <h5 class="text-secondary">🐾 Mascota</h5>
                <p><strong>Nombre:</strong> {{ $consulta->mascota->nombre }}</p>
                <p><strong>Cliente:</strong> {{ $consulta->mascota->cliente->name ?? 'Cliente no encontrado' }}</p>
            </div>

            <hr>

            <div class="mb-4">
                <h5 class="text-secondary">🩺 Consulta Médica</h5>
                <p><strong>Motivo:</strong> {{ $consulta->descripcion }}</p>
                <p><strong>Veterinario:</strong> {{ $consulta->veterinario->name }}</p>
            </div>

            <hr>

            <div class="mb-4">
                <h5 class="text-secondary">🛠️ Servicios Realizados</h5>
                <ul class="list-group">
                    @php $totalServicios = 0; @endphp
                    @foreach($consulta->servicios as $servicio)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $servicio->nombre }}
                            <span>Bs {{ number_format($servicio->precio, 2) }}</span>
                        </li>
                        @php $totalServicios += $servicio->precio; @endphp
                    @endforeach
                </ul>
            </div>

            <hr>

            <div class="mb-3">
                <p><strong>💼 Precio Consulta Médica:</strong> Bs {{ number_format($consulta->precio_consulta, 2) }}</p>
                <p><strong>🧮 Total Servicios:</strong> Bs {{ number_format($totalServicios, 2) }}</p>
                <h4 class="text-success fw-bold mt-3">💵 Total Pagado: Bs {{ number_format($consulta->precio_consulta + $totalServicios, 2) }}</h4>
            </div>

            <hr>

            <p class="mb-4"><strong>👨‍💼 Empleado que cobró:</strong> {{ $consulta->empleadoCobro->name }}</p>

            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-primary shadow">
                    <i class="fas fa-print"></i> Imprimir Recibo
                </button>
                <a href="{{ route('empleado.cobros.index') }}" class="btn btn-secondary shadow">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection