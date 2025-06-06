<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('{{ asset('img/Etología.webp') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-wrapper {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid #dbdbdb;
            padding: 35px 30px;
            width: 100%;
            max-width: 360px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(4px);
        }

        h2 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #262626;
            margin-bottom: 25px;
        }

        input[type=email] {
            width: 100%;
            padding: 12px;
            font-size: 0.95rem;
            border: 1px solid #dbdbdb;
            border-radius: 5px;
            background-color: #fafafa;
            margin-bottom: 18px;
        }

        input[type=email]:focus {
            outline: none;
            background-color: #fff;
            border-color: #bbb;
        }

        button {
            width: 100%;
            padding: 11px;
            background-color: #0095f6;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #007cd1;
        }

        .success {
            color: #16a34a;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .error {
            color: #ef4444;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .btn-secondary {
            margin-top: 18px;
            width: 100%;
            padding: 10px;
            background-color: #e5e5e5;
            color: #262626;
            font-weight: 500;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="reset-wrapper">
        <h2>Restablecer Contraseña</h2>

        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <input type="email" name="email" placeholder="Correo electrónico" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Enviar enlace</button>
        </form>

        <form action="{{ url('/') }}">
            <button type="submit" class="btn-secondary">Volver al inicio</button>
        </form>
    </div>
</body>
</html>


