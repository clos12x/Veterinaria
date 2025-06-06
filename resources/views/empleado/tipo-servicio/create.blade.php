@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Tipo de Servicio</h2>

    <form method="POST" action="{{ route('empleado.tipoServicio.store') }}">
        @csrf

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Descripción:</label>
        <textarea name="descripcion"></textarea><br><br>

        <button type="submit">💾 Guardar</button>
        <a href="{{ route('empleado.tipoServicio.index') }}">↩️ Volver</a>
    </form>
</div>
@endsection