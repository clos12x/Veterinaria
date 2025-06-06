@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="text-align: center;">🚨 Productos con Stock Bajo</h2>

    @if($productos->count())
        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="margin-top:20px;">
            <thead style="background-color: #ffc107;">
                <tr>
                    <th>Producto</th>
                    <th>Stock Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    @php
                        $stockTotal = $productosConStock->firstWhere('id_producto', $producto->id)->stock_total ?? 0;
                    @endphp
                    <tr style="background-color: {{ $stockTotal == 0 ? '#f8d7da' : '#fff3cd' }};">
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $stockTotal }} unidades</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: green; text-align:center;">✅ No hay productos con stock bajo actualmente.</p>
    @endif
</div>
@endsection
