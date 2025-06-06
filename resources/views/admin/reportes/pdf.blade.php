<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Administrativo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 20px;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            color: #343a40;
            margin-bottom: 30px;
            text-transform: uppercase;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
        }

        h3 {
            font-size: 16px;
            color: #0d6efd;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        h4 {
            font-size: 14px;
            margin-top: 15px;
        }

        p {
            margin: 2px 0;
            font-size: 12px;
        }

        .resumen {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .total-box {
            background-color: #198754;
            color: white;
            font-weight: bold;
            padding: 8px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        th {
            background-color: #0d6efd;
            color: white;
            padding: 8px;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <h2>Reporte Administrativo</h2>

    <div class="resumen">
        <h3>Resumen Económico (Hoy / Semana / Mes / Año)</h3>
        <p><strong>Consultas Hoy:</strong> Bs {{ number_format($consultasDia, 2) }}</p>
        <p><strong>Consultas Semana:</strong> Bs {{ number_format($consultasSemana, 2) }}</p>
        <p><strong>Consultas Mes:</strong> Bs {{ number_format($consultasMes, 2) }}</p>
        <p><strong>Consultas Año:</strong> Bs {{ number_format($consultasAño, 2) }}</p>

        <p><strong>Ventas Hoy:</strong> Bs {{ number_format($ventasDia, 2) }}</p>
        <p><strong>Ventas Semana:</strong> Bs {{ number_format($ventasSemana, 2) }}</p>
        <p><strong>Ventas Mes:</strong> Bs {{ number_format($ventasMes, 2) }}</p>
        <p><strong>Ventas Año:</strong> Bs {{ number_format($ventasAño, 2) }}</p>

        <p><strong>Servicios Hoy:</strong> Bs {{ number_format($serviciosDia, 2) }}</p>
        <p><strong>Servicios Semana:</strong> Bs {{ number_format($serviciosSemana, 2) }}</p>
        <p><strong>Servicios Mes:</strong> Bs {{ number_format($serviciosMes, 2) }}</p>
        <p><strong>Servicios Año:</strong> Bs {{ number_format($serviciosAño, 2) }}</p>
    </div>

    @if(request('fecha_inicio') && request('fecha_fin'))
        <div class="resumen">
            <h3>Resumen Filtrado</h3>
            <p><strong>Total Consultas:</strong> Bs {{ number_format($consultasTotal, 2) }}</p>
            <p><strong>Total Servicios:</strong> Bs {{ number_format($serviciosTotal, 2) }}</p>
            <p><strong>Total Ventas:</strong> Bs {{ number_format($ventasTotal, 2) }}</p>
            <h4><span class="total-box">Total General: Bs {{ number_format($totalGeneral, 2) }}</span></h4>
        </div>
    @endif

    <h3>Top Productos Más Vendidos</h3>
    <table>
        <thead>
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

    <h3>Top Veterinarios Más Activos</h3>
    <table>
        <thead>
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

</body>
</html>

