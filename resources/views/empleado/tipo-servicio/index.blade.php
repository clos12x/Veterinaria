@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tipos de Servicio</h2>

    <a href="{{ route('empleado.tipoServicio.create') }}">➕ Registrar Nuevo Tipo</a>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nombre }}</td>
                    <td>{{ $tipo->descripcion }}</td>
                    <td>
                        <form method="POST" action="{{ route('empleado.tipoServicio.destroy', $tipo->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este tipo?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No hay tipos de servicio.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection