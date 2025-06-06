<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>📄 Reporte de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 40px;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            color: white;
        }
        h2 {
            font-weight: 700;
            color: #0d6efd;
        }
        .btn-volver {
            background: linear-gradient(45deg, #6f42c1, #0d6efd);
            color: white;
            font-weight: 600;
        }
        .btn-volver:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-center w-100">📄 Reporte de Compras</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Total (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->proveedor->nombre ?? 'Proveedor eliminado' }}</td>
                            <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                            <td>Bs {{ number_format($compra->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h4 class="text-end mt-4 fw-bold text-primary">
                Total General: Bs {{ number_format($total, 2) }}
            </h4>

            <div class="mt-4 text-end">
              <a href="{{ route('admin.dashboard') }}"
               class="btn btn-secondary rounded-pill fw-semibold">
           <i class="fas fa-arrow-left me-1"></i> Volver al Panel
            </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
