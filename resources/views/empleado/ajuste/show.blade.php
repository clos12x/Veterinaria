@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-danger fw-bold mb-4">Detalle del Ajuste</h2>

    <div class="card shadow-sm p-4">
        <h5 class="mb-3">Nombre: <span class="fw-normal">{{ $ajuste->nombre }}</span></h5>
        <p><strong>Descripción:</strong> {{ $ajuste->descripcion ?? 'Sin descripción' }}</p>
        <p><strong>Creado el:</strong> {{ $ajuste->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Última actualización:</strong> {{ $ajuste->updated_at->format('d/m/Y H:i') }}</p>

        <div class="mt-4">
            <a href="{{ route('empleado.ajustes.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Volver a la lista
            </a>
        </div>
    </div>
</div>
@endsection
