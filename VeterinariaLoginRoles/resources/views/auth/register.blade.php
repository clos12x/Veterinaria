<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="name" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <label>Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" required><br><br>

        <label>Rol:</label>
        <select name="role" required>
            <option value="administrador">Administrador</option>
            <option value="cliente">Cliente</option>
            <option value="veterinario">Veterinario</option>
            <option value="empleado">Empleado</option>
        </select><br><br>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
