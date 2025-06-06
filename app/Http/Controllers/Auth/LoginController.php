<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Redirigir a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Manejar la respuesta de Google
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // Buscar o crear el usuario en la base de datos
        $findUser = User::where('email', $user->email)->first();

        if ($findUser) {
            auth()->login($findUser);
            return redirect()->route('home'); // O la página que desees redirigir después de loguearse
        } else {
            // Si el usuario no existe, crearlo
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt('randompassword'), // Contraseña temporal
            ]);
            auth()->login($newUser);
            return redirect()->route('home'); // O la página que desees redirigir después de registrarse
        }
    }

    // Redirigir a Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Manejar la respuesta de Facebook
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $findUser = User::where('email', $user->email)->first();

        if ($findUser) {
            auth()->login($findUser);
            return redirect()->route('home');
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt('randompassword'),
            ]);
            auth()->login($newUser);
            return redirect()->route('home');
        }
    }
    
}

