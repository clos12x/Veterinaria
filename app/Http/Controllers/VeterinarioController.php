<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Consulta;

class VeterinarioController extends Controller
{
    public function index()
    {
        $consultasPendientes = Consulta::where('id_veterinario', auth()->id())
            ->where('cobrado', 0)
            ->count();

        return view('dashboards.veterinario', compact('consultasPendientes'));
    }

    public function perfil()
    {
        return view('veterinario.perfil');
    }

    public function actualizarPerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
