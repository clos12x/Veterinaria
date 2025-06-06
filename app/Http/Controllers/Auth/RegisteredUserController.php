<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validación avanzada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // minúscula
                'regex:/[A-Z]/',      // mayúscula
                'regex:/[0-9]/',      // número
                'regex:/[@$!%*#?&]/', // símbolo
                'confirmed',
            ],
        ]);

        $tempPassword = $request->password;

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => 'cliente',
        ]);

        // Guardar contraseña en historial
        PasswordHistory::create([
            'user_id' => $user->id,
            'password' => $user->password,
        ]);

        // Autenticación automática
        Auth::login($user);

        // Redirección al dashboard del cliente
        return redirect()->route('cliente.dashboard')->with('success', '¡Registro exitoso! Bienvenido al sistema.');
    }
    public function verificarEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $existe = \App\Models\User::where('email', $request->email)->exists();

    return response()->json([
        'exists' => $existe
    ]);
}

}
