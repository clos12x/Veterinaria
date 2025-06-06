<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Venta</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 40px;
        }

        .titulo {
            text-align: center;
            font-size: 20px;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-width: 120px;
        }

        .seccion {
            margin-bottom: 15px;
        }

        .seccion p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f1f3f5;
            font-weight: bold;
        }

        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
        }

        .firma {
            margin-top: 50px;
            text-align: center;
        }

        .firma p {
            border-top: 1px solid #ccc;
            display: inline-block;
            padding-top: 5px;
            width: 200px;
        }
    </style>
</head>
<body>

    <div class="titulo"> Recibo de Venta </div>

    <div class="seccion">
        <p><strong>Cliente:</strong> {{ $orden->venta->cliente->name ?? 'No disponible' }}</p>
        <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>

        @php $direccion = $orden->direccion; @endphp

        @if($orden->tipo_entrega === 'delivery')
            <p><strong>Entrega:</strong>  Delivery</p>
            <p><strong>Dirección:</strong>
                {{ $direccion->direccion ?? '-' }},
                {{ $direccion->zona ?? '-' }} -
                {{ $direccion->ciudad ?? '-' }}
            </p>
            <p><strong>Referencia:</strong> {{ $direccion->referencia ?? '-' }}</p>
            <p><strong>Teléfono:</strong> {{ $direccion->telefono ?? '-' }}</p>
        @else
            <p><strong>Entrega:</strong> Retiro en veterinaria</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                    <td>Bs {{ number_format($detalle->precio_unitario ?? 0, 2) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs {{ number_format(($detalle->precio_unitario ?? 0) * $detalle->cantidad, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total: Bs {{ number_format($orden->venta->total, 2) }}</p>

            <div class="firma">
                <p>Firma y sello</p>
            </div>

            <div style="text-align: center; margin-top: 40px; font-size: 14px; color: #198754;">
                <strong>Gracias por su compra. ¡Esperamos verle pronto! </strong>
            </div>
</body>
</html>