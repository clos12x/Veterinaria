<?php

namespace App\Http\Controllers\Veterinario;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Servicio;

class ConsultaVeterinarioController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('mascota', 'empleado')
            ->where('id_veterinario', auth::id())
            ->latest()
            ->get();

        return view('veterinario.consulta.index', compact('consultas'));
    }

    public function formularioServicio($id)
    {
        $consulta = Consulta::with('mascota', 'servicios')->findOrFail($id);
        return view('veterinario.consulta.agregar-servicio', compact('consulta'));
    }

    public function guardarServicio(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Servicio::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'id_consulta' => $id,
        ]);

        return back()->with('success', 'Servicio agregado correctamente.');
    }
}