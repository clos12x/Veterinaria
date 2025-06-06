<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil del Empleado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f9fafb;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      padding: 2rem;
      max-width: 700px;
      margin: 2rem auto;
    }

    .form-title {
      color: #BE123C;
      margin-bottom: 1.5rem;
    }

    .form-group img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #BE123C;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="form-card">
    <h4 class="form-title"><i class="fas fa-user-edit me-2"></i>Editar Perfil</h4>

    <div class="mb-3 text-center">
      <img src="{{ Auth::user()->foto ? asset('img/empleados/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=BE123C&color=fff' }}" alt="Avatar">
    </div>

    <form action="{{ route('empleado.actualizarPerfil') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="name" class="form-label">Nombre completo</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
      </div>

      <div class="mb-3">
        <label for="foto" class="form-label">Cambiar foto de perfil</label>
        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
      </div>

      <div class="d-flex justify-content-between">
        <a href="{{ route('empleado.perfil') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar cambios
        </button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
