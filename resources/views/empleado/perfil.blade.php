<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil del Empleado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    :root {
      --primary: #BE123C;
      --primary-dark: #9F1239;
      --secondary: #10B981;
    }

    body {
      background-color: #f9fafb;
      font-family: 'Segoe UI', sans-serif;
    }

    .profile-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      padding: 2rem;
      max-width: 700px;
      margin: 2rem auto;
    }

    .profile-header {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .profile-header img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid var(--primary);
    }

    .profile-info {
      margin-top: 1.5rem;
    }

    .profile-info h5 {
      color: var(--primary-dark);
      margin-bottom: 1rem;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #e5e7eb;
      padding: 0.5rem 0;
    }

    .info-item span {
      color: #374151;
    }

    .btn-group-custom {
      margin-top: 2rem;
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }
  </style>
</head>
<body>
  <div class="profile-card">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="profile-header">
      <img src="{{ Auth::user()->foto ? asset('img/empleados/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=BE123C&color=fff' }}" alt="Avatar">
      <div>
        <h4 class="mb-0">{{ Auth::user()->name }}</h4>
        <small class="text-muted">{{ Auth::user()->email }}</small>
      </div>
    </div>

    <div class="profile-info">
      <h5>Información Personal</h5>
      <div class="info-item">
        <strong>Nombre:</strong>
        <span>{{ Auth::user()->name }}</span>
      </div>
      <div class="info-item">
        <strong>Correo:</strong>
        <span>{{ Auth::user()->email }}</span>
      </div>
      <div class="info-item">
        <strong>Teléfono:</strong>
        <span>{{ Auth::user()->telefono ?? 'No registrado' }}</span>
      </div>
      <div class="info-item">
        <strong>Rol:</strong>
        <span>{{ Auth::user()->rol ?? 'Empleado' }}</span>
      </div>
      <div class="info-item">
        <strong>Registrado:</strong>
        <span>{{ Auth::user()->created_at->format('d/m/Y') }}</span>
      </div>
    </div>

    <div class="btn-group-custom">
      <a href="{{ route('empleado.editarPerfil') }}" class="btn btn-primary">
        <i class="fas fa-user-edit"></i> Editar Perfil
      </a>
      <a href="{{ route('empleado.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Desaparecer automáticamente el mensaje de éxito después de 4 segundos
    setTimeout(function() {
      const alert = document.getElementById('success-alert');
      if (alert) {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bsAlert.close();
      }
    }, 4000);
  </script>
</body>
</html>