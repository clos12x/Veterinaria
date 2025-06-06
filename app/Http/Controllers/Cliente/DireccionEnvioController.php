<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DireccionEnvio;

class DireccionEnvioController extends Controller
{
    // Mostrar la dirección actual (si existe)
    public function index()
    {
        $direccion = auth()->user()->direccionesEnvio()->first();
        return view('cliente.direccion.index', compact('direccion'));
    }

    // Registrar nueva dirección
    public function store(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string',
            'zona' => 'nullable|string',
            'ciudad' => 'required|string',
            'referencia' => 'nullable|string',
            'telefono' => 'required|string',
        ]);

        auth()->user()->direccionesEnvio()->create($request->all());

        return redirect()->back()->with('success', 'Dirección registrada correctamente.');
    }

    // Actualizar dirección existente
    public function update(Request $request, DireccionEnvio $direccion)
    {
        // Verificamos que la dirección pertenezca al usuario autenticado
        if ($direccion->user_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'direccion' => 'required|string',
            'zona' => 'nullable|string',
            'ciudad' => 'required|string',
            'referencia' => 'nullable|string',
            'telefono' => 'required|string',
        ]);

        $direccion->update($request->all());

        return redirect()->back()->with('success', 'Dirección actualizada correctamente.');
    }

    // Eliminar dirección
    public function destroy(DireccionEnvio $direccion)
    {
        if ($direccion->user_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }

        $direccion->delete();
        return redirect()->back()->with('success', 'Dirección eliminada.');
    }
}