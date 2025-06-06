<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ConsultaController extends Controller
{
    public function create()
    {
        $mascotas = Mascota::with('cliente')->get();
        $veterinarios = User::where('role', 'veterinario')->get();
        return view('empleado.consulta.create', compact('mascotas', 'veterinarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'id_mascota' => 'required|exists:mascotas,id',
            'id_veterinario' => 'required|exists:users,id',
        ]);

        Consulta::create([
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'id_mascota' => $request->id_mascota,
            'id_empleado' => Auth::id(),
            'id_veterinario' => $request->id_veterinario,
            'precio_consulta' => 20.00,
        ]);

        return redirect()->route('empleado.consulta.create')->with('success', 'Consulta registrada.');
    }
}